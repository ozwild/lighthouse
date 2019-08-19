@push('scripts')
    <script>
        class VideoHelper {

            #recordModel;
            player;
            containerId = 'player';
            shouldLoop = true;
            currentState;

            #eventHandlers = {
                load: [],
                ready: [],
                stateChange: [],
                unstarted: [],
                ended: [],
                playing: [],
                paused: [],
                buffering: [],
                cued: [],
                stopped: [],
                tick: []
            };

            #autoStartVideo = function () {
                if (this.video_start) {
                    this.player.seekTo(this.video_start);
                }
            };

            constructor(containerId) {
                if (containerId) {
                    this.containerId = containerId;
                }
                window.eventHandlers = this.#eventHandlers;
            }

            on(eventName, event) {
                let list = this.#eventHandlers[eventName];
                if (list === undefined) {
                    throw "Unlisted event";
                }
                if (typeof event !== "function") {
                    throw "A function is expected as event handler";
                }
                list.push(event);
            }

            trigger(eventName, ...args) {
                let list = this.#eventHandlers[eventName];
                if (list === undefined) {
                    throw "Unlisted event";
                }

                list.forEach(handler => handler.call(this, ...args));
            }

            initialize() {
                let instance = this;
                this.player = new YT.Player(instance.containerId, {
                    width: '426',
                    height: '240',
                    videoId: instance.youtube_id,
                    events: {
                        'onReady': e => {
                            instance.onPlayerReady(e);
                        },
                        'onStateChange': e => {
                            instance.onPlayerStateChange(e);
                        }
                    }
                });
                this.#heartbeat();
            }

            #heartbeat = function () {

                let instance = this;
                let start;

                window.requestAnimationFrame(function tick(timestamp) {
                    if (!start) {
                        start = timestamp;
                    }
                    let progress = timestamp - start;

                    if (progress > 250 && instance.isPlaying) {
                        start = null;
                        let videoTimestamp = instance.currentTimestamp;
                        instance.trigger('tick', videoTimestamp);
                    }

                    window.requestAnimationFrame(tick);

                });

            };

            onPlayerReady(e) {
                this.trigger('load', e);
                this.#autoStartVideo();
                this.trigger('ready', e);
            }

            get isPlaying() {
                switch (this.currentState) {
                    case YT.PlayerState.PLAYING:
                        return true;
                        return false;
                }
            }

            onPlayerStateChange(e) {
                this.trigger('stateChange', e);
                this.currentState = e.data;
                if (e.data === YT.PlayerState.UNSTARTED) {
                    this.trigger('unstarted', e);
                    this.trigger('stopped', e);
                }
                if (e.data === YT.PlayerState.ENDED && this.shouldLoop) {
                    this.trigger('ended', e);
                    this.trigger('stopped', e);
                    this.restartVideo();
                }
                if (e.data === YT.PlayerState.PLAYING) {
                    this.trigger('playing', e);
                }
                if (e.data === YT.PlayerState.PAUSED) {
                    this.trigger('paused', e);
                    this.trigger('stopped', e);
                }
                if (e.data === YT.PlayerState.BUFFERING) {
                    this.trigger('buffering', e);
                    this.trigger('stopped', e);
                }
                if (e.data === YT.PlayerState.CUED) {
                    this.trigger('cued', e);
                    this.trigger('stopped', e);
                }
            }

            set recordModel(record) {
                this.#recordModel = record;
                this.youtube_id = this.#recordModel.youtube_id;
                this.video_start = this.#recordModel.video_start;
            }

            restartVideo() {
                if (this.video_start) {
                    this.player.seekTo(this.video_start);
                } else {
                    this.player.seekTo(0);
                }
            }

            get currentTimestamp() {
                return this.player.getCurrentTime();
            }

            play() {
                this.player.playVideo();
            }

            pause() {
                this.player.pauseVideo();
            }

            stop() {
                this.player.stopVideo();
            }

            mute() {
                this.player.mute();
            }

            unmute() {
                this.player.unmute();
            }

            get isMuted() {
                return this.player.isMuted();
            }

        }
    </script>
@endpush
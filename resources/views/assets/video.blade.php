@push('scripts')
    <script>
        class VideoHelper {

            #recordModel;
            player;
            containerId = 'player';
            shouldLoop = true;

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
                stopped: []
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

                list.forEach(handler => handler.apply(this, ...args));
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
            }

            onPlayerReady(e) {
                this.trigger('load', e);
                this.#autoStartVideo();
                this.trigger('ready', e);
            }

            onPlayerStateChange(e) {
                this.trigger('stateChange', e);
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
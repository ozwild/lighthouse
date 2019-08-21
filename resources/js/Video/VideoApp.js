import Eventful from '../Helpers/Eventful';

export default class VideoApp extends Eventful {

    record;
    player;
    containerId;
    shouldLoop = true;
    currentState;

    eventHandlers = {
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

    constructor(record, containerId) {

        super();

        this.record = record;
        this.youtube_id = this.record.youtube_id;
        this.video_start = this.record.video_start;

        if (!containerId) {
            throw "A valid DOM selector is required to initialize Lyrics Controls";
        }

        this.containerId = containerId;

        this._bindings();
        this.initialize();

    }

    _bindings() {
        this.on('ready', () => this.#autoStartVideo());
        this.on('ended', () => this.shouldLoop ? this.restartVideo() : null);
        this.on('stateChange', e => {

            this.currentState = e.data;

            switch (e.data) {
                case YT.PlayerState.UNSTARTED:
                    return this.trigger(['unstarted', 'stopped'], e);
                case YT.PlayerState.ENDED:
                    return this.trigger(['ended', 'stopped'], e);
                case YT.PlayerState.PLAYING:
                    return this.trigger('playing', e);
                case YT.PlayerState.PAUSED:
                    return this.trigger(['paused', 'stopped'], e);
                case YT.PlayerState.BUFFERING:
                    return this.trigger(['buffering', 'stopped'], e);
                case YT.PlayerState.CUED:
                    return this.trigger(['cued', 'stopped'], e);
            }

        })
    }

    initialize() {
        this.player = new YT.Player(this.containerId, {
            width: '426',
            height: '240',
            videoId: this.youtube_id,
            events: {
                'onReady': e => this.trigger('ready', e),
                'onStateChange': e => this.trigger('stateChange', e)
            }
        });
        this.#heartbeat();
    }

    #heartbeat = function () {

        let instance = this;
        let start;

        window.requestAnimationFrame(function tick(timestamp) {
            if (!start) start = timestamp;
            let progress = timestamp - start;

            if (progress > 250 && instance.isPlaying) {
                start = null;
                let videoTimestamp = instance.currentTimestamp;
                instance.trigger('tick', videoTimestamp);
            }

            window.requestAnimationFrame(tick);

        });

    };

    set record(record) {
        console.error("Record reassignment is forbidden. Can't assign `" + record.name + "`,  `" + this.name + "` already assigned.");
    }

    restartVideo() {
        if (this.video_start) {
            this.player.seekTo(this.video_start);
        } else {
            this.player.seekTo(0);
        }
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

    get isPlaying() {
        return this.currentState === YT.PlayerState.PLAYING;
    }

    get currentTimestamp() {
        return this.player.getCurrentTime();
    }

}
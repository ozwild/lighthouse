import {debounce} from "../../Helpers/functions";

export default class SliderUIControl {

    #videoService;

    timestamp = 0;
    progress = 0;
    buffer = 0;
    #playerUpdateTimeout;
    updatingPlayer = false;

    $elements = {
        $container: null,
        $progressBar: null,
        $bufferBar: null,
        $input: null
    };

    constructor($html, videoService) {

        this.#videoService = videoService;

        this.$elements.$container = $html.find('.slider-control');
        this.$elements.$progressBar = $html.find('.progress-bar');
        this.$elements.$bufferBar = $html.find('.buffer-bar');
        this.$elements.$input = $html.find('input');
        this.$elements.$input.val(0);

        this.#binds();

    }

    #binds() {

        this.#videoService.on('tick', e => {
            if (!this.updatingPlayer)
                this.#setTimestamp(this.#videoService.currentTimestamp)
        });

        this.$elements.$input.on('change', e => {
            this.#setProgress(this.getInputValue());
        });

        this.$elements.$input.on('input', e => {
            this.#setProgress(this.getInputValue());
        });
    }

    getInputValue() {
        return Number(this.$elements.$input[0].value) / 10;
    }

    progressToTimestamp(progress, duration = this.duration) {
        return (progress * duration) / 100;
    }

    timestampToProgress(timestamp, duration = this.duration) {
        return (timestamp * 100) / duration;
    }

    set timestamp(timestamp) {
        this.#setTimestamp(timestamp);
    }

    #setTimestamp(timestamp) {

        if (timestamp < 0 || timestamp > this.duration) {
            return;
        }

        this.timestamp = timestamp;
        this.progress = this.timestampToProgress(this.timestamp);

        this.updateProgress();
    }

    set progress(progress) {
        this.#setProgress(progress);
    }

    #setProgress(progress) {
        if (progress < 0 || progress > 100) {
            return;
        }

        let _this = this;
        this.progress = progress;
        this.timestamp = this.progressToTimestamp(this.progress);
        this.updatingPlayer = true;

        this.updateProgress();

        clearTimeout(_this.#playerUpdateTimeout);

        this.#playerUpdateTimeout = setTimeout(function () {
            _this.updatePlayer();
        }, 450);

    }

    updatePlayer() {
        this.#videoService.seekTo(this.timestamp);
        this.updatingPlayer = false;
    }

    get duration() {
        return this.#videoService.duration;
    }

    get buffer() {
        if (this.buffer > 1000) {
            return 100;
        }

        return this.buffer / 10;
    }

    updateProgress() {
        this.$elements.$progressBar[0].style.width = this.progress.toFixed(2) + "%";
    }

    updateBuffer() {
        this.$elements.$bufferBar[0].style.width = this.buffer.toFixed(2) + "%";
    }

}

export default class StopUIControl {

    #videoService;
    $element;

    constructor($html, videoService) {
        this.$element = $html.find('.stop');
        this.#videoService = videoService;
        this.#binds();
    }

    #binds() {
        this.$element.on('click', e => this.action());
    }

    action() {
        this.#videoService.stop();
    }

}
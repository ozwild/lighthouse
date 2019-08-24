export default class PauseUIControl {

    #videoService;
    $element;

    constructor($html = "", videoService) {
        this.$element = $html.find('.pause');
        this.#videoService = videoService;
        this.#binds();
    }

    #binds() {
        this.$element.on('click', e => this.action());
    }

    action() {
        this.#videoService.pause();
    }

}
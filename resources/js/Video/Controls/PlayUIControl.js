export default class PlayUIControl {

    #videoService;
    $element;

    constructor($html, videoService) {
        this.$element = $html.find('.play');
        this.#videoService = videoService;
        this.#binds();
    }

    #binds() {
        this.$element.on('click', e => this.action());
    }

    action() {
        this.#videoService.play();
    }

}
import Service from './LyricsDisplayService';

export default class LyricsDisplayController {

    static _instance;
    static _$container;
    service;
    canBeDisplayed;

    static load($container) {
        this._$container = $("<div>").addClass(["lyrics-container", "display"]);
        this._$container.appendTo($container);
    }

    static instance(song) {
        if (!this._instance) {
            if (!song) {
                /**
                 * Implement song service and controller
                 * to provide with song data on demand
                 */
                throw "Can't initialize without a song";
            }
            this._instance = new LyricsDisplayController(song, this._$container);
        }
        return this._instance;
    }

    constructor(song, $container) {
        this.service = new Service(song, $container);
        this.canBeDisplayed = !!song.lyrics;
        this.service.process();
        this.service.render();
    }

    on(event, handler) {
        this.service.on(event, handler);
        return this;
    }

}
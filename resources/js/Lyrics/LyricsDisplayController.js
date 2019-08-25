import Service from './LyricsDisplayService';

export default class LyricsDisplayController {

    static _instance;
    static _$container;
    service;

    static load($container) {
        this._$container = $("<div>").addClass(["lyrics-container", "display"]);
        this._$container.appendTo($container);
    }

    static instance(record) {
        if (!this._instance) {
            if (!record) {
                /**
                 * Implement record service and controller
                 * to provide with record data on demand
                 */
                throw "Can't initialize without a record";
            }
            this._instance = new LyricsDisplayController(record, this._$container);
        }
        return this._instance;
    }

    constructor(record, $container) {
        this.service = new Service(record, $container);
        this.service.process();
        this.service.render();
    }

    on(event, handler) {
        this.service.on(event, handler);
        return this;
    }

}
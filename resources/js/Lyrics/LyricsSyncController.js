import Service from './LyricsSyncService';
import VideoController from "../Video/VideoController";

export default class LyricsSyncController {

    static _instance;
    static _$container;
    service;
    $container;

    static load($container) {
        this._$container = $("<div>").addClass(["lyrics-container", "sync"]);
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
            this._instance = new LyricsSyncController(record, this._$container);
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
import Service from './VideoService'
import VideoUIControl from './VideoUIControl';

export default class VideoController {

    static _instance;
    static _$container;

    service;
    UIControl;
    $container;

    static load($container) {
        this._$container = $("<div>").addClass("player-container");
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
            this._instance = new VideoController(record, this._$container);
        }
        return this._instance;
    }

    constructor(record, $container) {
        this.service = new Service(record, $container);
        this.service.shouldAutoStart = false;
        this.service.initialize();
        this.UIControl = new VideoUIControl(this.service);
    }



    on(event, handler) {
        this.service.on(event, handler);
        return this;
    }

}
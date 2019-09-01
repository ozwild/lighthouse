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

    static instance(song) {
        if (!this._instance) {
            if (!song) {
                /**
                 * Implement song service and controller
                 * to provide with song data on demand
                 */
                throw "Can't initialize without a song";
            }
            this._instance = new VideoController(song, this._$container);
        }
        return this._instance;
    }

    constructor(song, $container) {
        this.service = new Service(song, $container);
        this.service.shouldAutoStart = false;
        this.service.initialize();
        this.UIControl = new VideoUIControl(this.service);
    }



    on(event, handler) {
        this.service.on(event, handler);
        return this;
    }

}
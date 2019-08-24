import Service from './VideoService'
import VideoUIControl from './VideoUIControl';

export default class VideoController {

    static service;
    static UIControl;

    static load(record, selector) {
        this.service = new Service(record, selector);
        this.service.shouldAutoStart = false;
        this.service.initialize();
        this.UIControl = new VideoUIControl(this.service);
    }

}
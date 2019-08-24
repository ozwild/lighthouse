import Service from './LyricsSyncService';
import VideoController from "../Video/VideoController";

export default class LyricsSyncController {

    static service;

    static load(record, selector) {
        this.service = new Service(record, selector);
        this.service.process();
        this.service.render();
    }

    static pairVideoController(videoController) {

        if (videoController.name !== "VideoController") {
            throw "An instance of VideoController is expected";
        }

        let videoService = videoController.service;
        videoService.on('ready', () => {
        });
        this.service.on('step', () => {
            this.service.next(videoService.currentTimestamp);
        });
    }

}
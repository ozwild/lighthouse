import app from './SyncApp';
import VideoController from "../Video/VideoController";

export default class LyricsSyncController {

    static app;

    static load(record, selector) {
        this.app = new app(record, selector);
        this.app.process();
        this.app.render();
    }

    static pairVideoController(controller) {

        if (controller.name !== "VideoController") {
            throw "An instance of VideoController is expected";
        }

        let videoApp = controller.app;
        videoApp.on('ready', () => {
            this.app.selectNextLyric();
        });
        this.app.on('step', () => {
            this.app.next(VideoController.app.currentTimestamp);
        });
    }

}
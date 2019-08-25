import VideoController from '../Video/VideoController';
import LyricsController from '../Lyrics/LyricsDisplayController'
import YTAPILoader from '../Video/YTAPI';

export default class LyricsDisplayApp {

    videoController;
    lyricsController;

    static load(selector = '.body-content') {
        let $container = $(selector);
        VideoController.load($container);
        LyricsController.load($container);
    }

    constructor(recordModel) {

        YTAPILoader.load().then(() => {

            this.videoController = VideoController.instance(recordModel);
            this.lyricsController = LyricsController.instance(recordModel);

            this.videoController.on('tick', timestamp => {
                this.lyricsController.service.showLyricsForTime(timestamp);
            });

        });
    }


}
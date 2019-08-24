import VideoController from '../Video/VideoController';
import LyricsController from '../Lyrics/LyricsDisplayController'
import YTAPILoader from '../Video/YTAPI';

export default class LyricsDisplayApp {

    videoController;
    lyricsController;

    constructor(recordModel) {

        this.videoController = VideoController;
        this.lyricsController = LyricsController;

        YTAPILoader.load().then(() => {

            VideoController.load(recordModel, 'player');
            LyricsController.load(recordModel, '.lyrics-container');

            VideoController.service.on('tick', timestamp => {
                LyricsController.service.showLyricsForTime(timestamp);
            });

        });
    }


}
import VideoController from '../Video/VideoController';
import LyricsController from '../Lyrics/LyricsSyncController'
import YTAPILoader from '../Video/YTAPI';

export default class LyricsSyncApp {

    videoController;
    lyricsController;

    constructor(recordModel) {

        this.videoController = VideoController;
        this.lyricsController = LyricsController;

        YTAPILoader.load().then(() => {

            VideoController.load(recordModel, 'player');
            LyricsController.load(recordModel, '.lyrics-container');
            LyricsController.pairVideoController(VideoController);

        });

    }

    save(route) {

        if (!LyricsController.app) {
            return M.toast('No lyrics controller found');
        }

        let lyrics = LyricsController.app.toString();

        $.ajax(route, {
            method: 'patch',
            data: {
                lyrics
            },
            dataType: 'json',
        }).done(e => {
            M.toast("Lyrics saved!");
        }).fail(e => {
            M.toast("Something went wrong");
        });

    }


}
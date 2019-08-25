import VideoController from '../Video/VideoController';
import LyricsController from '../Lyrics/LyricsSyncController'
import YTAPILoader from '../Video/YTAPI';

export default class LyricsSyncApp {

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

            this.lyricsController.on('step', () => {
                this.lyricsController.service.next(this.videoController.service.currentTimestamp);
            });

        });

    }

    save(route) {

        if (!this.lyricsController) {
            return M.toast({html: "No lyrics controller found", classes: "fail"});
        }

        let lyrics = this.lyricsController
            .service.toString();

        $.ajax(route, {
            method: 'patch',
            data: {lyrics},
            dataType: 'json',
        }).done(e => {
            M.toast({html: "Lyrics saved!", classes: "success"});
        }).fail(e => {
            M.toast({html: "Something went wrong", classes: "alert"});
        });

    }


}
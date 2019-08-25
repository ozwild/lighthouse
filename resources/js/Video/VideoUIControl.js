import ProgressSlider from "./Controls/SliderUIControl";
import PlayUIControl from "./Controls/PlayUIControl";
import PauseUIControl from "./Controls/PauseUIControl";
import StopUIControl from "./Controls/StopUIControl";

export default class VideoUIControl {

    #videoService;

    UIControls = {
        play: null,
        pause: null,
        stop: null,
        slider: null
    };

    constructor(videoService) {
        this.#videoService = videoService;
        this.initialize();
    }

    initialize() {

        return new Promise((resolve, reject) => {

            $.get('/api/video-controls')
                .done(html => {

                    let $html = $(html);

                    this.UIControls.play = new PlayUIControl($html, this.#videoService);
                    this.UIControls.pause = new PauseUIControl($html, this.#videoService);
                    this.UIControls.stop = new StopUIControl($html, this.#videoService);
                    this.UIControls.slider = new ProgressSlider($html, this.#videoService);

                    $html.appendTo(this.#videoService.$container);

                    this.#bindings();

                    resolve();

                })
                .fail(error => reject(error));

        });

    }

    #bindings() {

        
    }

}
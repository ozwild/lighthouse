import app from './DisplayApp';

export default class LyricsDisplayController {

    static app;

    static load(recordModel, selector) {
        this.app = new app(recordModel, selector);
        this.app.process();
        this.app.render();
    }
}
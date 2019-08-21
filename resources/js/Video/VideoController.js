import app from './VideoApp'

export default class VideoController {

    static app;
    static isReady = false;

    static load(record, selector) {
        this.app = new app(record, selector);
        this.bindings();
        this.isReady = true;
    }

    static bindings() {

        this.app.on('playing', () => {
        });
        this.app.on('stopped', () => {
        });
        this.app.on('tick', () => {
        });

    }

}
import Service from './LyricsDisplayService';

export default class LyricsDisplayController {

    static service;

    static load(recordModel, selector) {
        this.service = new Service(recordModel, selector);
        this.service.process();
        this.service.render();
    }
}
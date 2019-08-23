import app from './VideoApp'
import {createDOMButton, createDOMElement} from "../Helpers/DOM";

export default class VideoController {

    static app;
    static isReady = false;
    static control = {
        $container: null,
        buttons: {}
    };

    static load(record, selector) {
        this.app = new app(record, selector);
        this.app.shouldAutoStart = false;
        this.#initializeControls();
        this.isReady = true;
    }

    static #initializeControls() {
        let $container = createDOMElement({classNames: ['player-controls'], type: 'footer'});
        let $buttons = this.#createButtons();
        $container.append(Object.values($buttons));
        $container.appendTo(".body-content");
        this.control.$container = $container;
        this.control.buttons = $buttons;
    }

    static #createButtons() {

        let $play = createDOMButton({
            icon: 'play_arrow',
            classNames: ['player-control', 'play'],
            handler: () => this.app.play()
        });

        let $pause = createDOMButton({
            icon: "pause",
            classNames: ['player-control', 'pause'],
            handler: () => this.app.pause()
        });

        let $stop = createDOMButton({
            icon: "stop",
            classNames: ['player-control', 'stop'],
            handler: () => this.app.stop()
        });

        this.app.on('playing', () => {
            $pause.show();
            $play.hide();
        });

        this.app.on('paused', () => {
            $play.show();
            $pause.hide();
        });

        this.app.on('stopped', () => {
            $play.show();
            $pause.hide();
        });

        return {
            $play, $pause, $stop
        }

    }

}
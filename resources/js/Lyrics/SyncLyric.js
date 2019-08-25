import Lyric from './Lyric';
import {createDOMElement} from "../Helpers/DOM";

export default class SyncLyric extends Lyric {

    static #userNotificationTimeout;

    constructor(text) {
        super(text);
        this.#binds();
    }

    _createNodes() {

        this.$element = createDOMElement({
            type: 'p',
            classNames: 'lyric',
        }).data('lyric_id', this.id);

        this.$nodes.$start = createDOMElement({
            type: 'span',
            classNames: ['timestamp', 'lyric-start'],
            content: this._start,
            editable: true,
            $container: this.$element
        });

        this.$nodes.$end = createDOMElement({
            type: 'span',
            classNames: ['timestamp', 'lyric-end'],
            content: this._end,
            editable: true,
            $container: this.$element
        });

        this.$nodes.$content = createDOMElement({
            type: 'span',
            classNames: 'lyric-content',
            content: this.content,
            $container: this.$element
        });

        this.updateNodesData();

    };

    static _notifyValidationFailure() {
        clearTimeout(this.#userNotificationTimeout);
        this.#userNotificationTimeout = setTimeout(() => M.toast({
            html: "Numbers accepted only",
            classes: "info"
        }), 450);
    }

    static _validateKeyboardStrokes(event) {

        let shouldStopPropagation = false;
        let shouldPreventDefault = false;
        let shouldValidate = true;

        if (["ArrowRight", "ArrowRight", "End", "Home", "Tab"].includes(event.key)) {
            shouldStopPropagation = true;
            shouldValidate = false;
        }

        if (event.key === "Enter") {
            shouldStopPropagation = true;
            shouldValidate = false;
            event.currentTarget.blur();
        }

        let keyCode = event.key.codePointAt(0);

        if (keyCode === 32) { // Space bar key
            shouldStopPropagation = true;
            shouldValidate = false;
        }

        if (shouldValidate && !(/^[0-9.]+$/.test(event.key))) {
            shouldPreventDefault = true;
            SyncLyric._notifyValidationFailure();
        }

        if (shouldStopPropagation)
            event.stopPropagation();

        if (shouldPreventDefault)
            event.preventDefault();

    }

    static _validatePastedData(event) {

        let clipboardData = event.originalEvent
            .clipboardData.getData('text/plain');

        if (!(/^[0-9.]+$/.test(clipboardData))) {
            event.preventDefault();
            SyncLyric._notifyValidationFailure();
        }

    }

    #binds() {

        this.$nodes.$start
            .on('click', e => e.stopPropagation())
            .on('keypress', SyncLyric._validateKeyboardStrokes)
            .on('paste', SyncLyric._validatePastedData)
            .on('keyup', e => {
                if (e.key === "Escape") {
                    e.stopPropagation();
                    e.currentTarget.innerHtml = this._start;
                    e.currentTarget.blur()
                }
            })
            .on('blur', e => {
                this.start = this.$nodes.$start.text();
            });

        this.$nodes.$end
            .on('click', e => e.stopPropagation())
            .on('keypress', SyncLyric._validateKeyboardStrokes)
            .on('paste', SyncLyric._validatePastedData)
            .on('keyup', e => {
                if (e.key === "Escape") {
                    e.stopPropagation();
                    e.currentTarget.innerHtml = this._end;
                    e.currentTarget.blur()
                }
            })
            .on('blur', e => {
                this.end = this.$nodes.$end.text();
            });

    }

    updateNodesData() {
        this.$element.attr('data-start', this._start);
        this.$element.attr('data-end', this._end);
        this.$nodes.$content.html(this.content);
        this.$nodes.$start.html(this._start);
        this.$nodes.$end.html(this._end);
    }


}

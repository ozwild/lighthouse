import $ from 'jquery';
import {TIMESTAMPS_IDENTIFIERS} from "./Constants";
import * as DOM from "../Helpers/DOM";
import {encode, decode} from "../Helpers/Data";
import {createDOMElement} from "../Helpers/DOM";

export default class Lyric {

    id;
    content;
    start;
    end;
    $element;

    isSelected;
    isActive;
    activeTimestampIdentifier;

    constructor(text) {

        let decoded = decode(text);

        this.id = Symbol('lyric_id');
        this.content = decoded.content;
        this.start = decoded.start;
        this.end = decoded.end;
        this.$element = this._createNode();
        this.updateNodeData();
    }

    _createNode() {
        return createDOMElement("p", 'lyrics-line').data('lyric_id', this.id);
    };

    updateNodeData() {
        this.$element.html(this.content);
        this.$element.attr('data-start', this.start);
        this.$element.attr('data-end', this.end);
    }

    select() {
        this.isSelected = true;
        this.activeTimestampIdentifier = TIMESTAMPS_IDENTIFIERS.START;
    }

    deselect() {
        this.isSelected = false;
        this.activeTimestampIdentifier = null;
    }

    activate() {
        this.isActive = true;
    }

    deactivate() {
        this.isActive = false;
    }

    get verticalPosition() {
        let height = this.$element.height() / 2;
        let offset = this.$element[0].offsetTop;
        let correction = 0;
        return height + offset + correction;
    }

    get id() {
        return this.id;
    }

    set id(id) {
        console.error("Couldn't assign id:`${id}`. Lyric Id is automatically assigned")
    }

    updateTimestamp(timestamp) {

        timestamp = +timestamp.toFixed(2);

        switch (this.activeTimestampIdentifier) {

            case TIMESTAMPS_IDENTIFIERS.START:
                this.start = timestamp;
                this.activeTimestampIdentifier = TIMESTAMPS_IDENTIFIERS.END;
                return;

            case TIMESTAMPS_IDENTIFIERS.END:
                this.end = timestamp;
                this.activeTimestampIdentifier = null;
                return;

        }

        this.repaintTimestampState();

    }

    set start(timestamp) {
        this.start = timestamp;
        this.updateNodeData();
    }

    set end(timestamp) {
        this.start = timestamp;
        this.updateNodeData();
    }

    set content(content) {
        this.content = content;
        this.updateNodeData();
    }

    repaintSelectionState() {
        let stateClass = "selected";

        if (this.isSelected) {
            this.$element.addClass(stateClass);
        } else
            this.$element.removeClass(stateClass);

        this.repaintTimestampState();
    }

    repaintTimestampState() {

        this.$element.find('.lyric-start, .lyric-end').removeClass("active");

        if (this.activeTimestampIdentifier === TIMESTAMPS_IDENTIFIERS.END)
            this.$element.find('.lyric-end').addClass("active");

        else if (this.activeTimestampIdentifier === TIMESTAMPS_IDENTIFIERS.START)
            this.$element.find('.lyric-start').addClass("active");
    }

    repaintActiveState() {
        let stateClass = "active";

        if (this.isActive)
            this.$element.addClass(stateClass);
        else
            this.$element.removeClass(stateClass);
    }

    toString() {
        return encode(this);
    }

}
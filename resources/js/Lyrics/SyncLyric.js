import Lyric from './Lyric';
import {createDOMElement} from "../Helpers/DOM";

export default class SyncLyric extends Lyric {

    constructor(record, selector) {
        super(record, selector);
        this.$element = this._createNode();
    }

    _createNode() {
        let $contentBlock = createDOMElement("div", "lyric-content", this.content);
        let $startBlock = createDOMElement("div", "timestamp lyric-start", this.start);
        let $endBlock = createDOMElement("div", "timestamp lyric-end", this.end);

        return createDOMElement("div", "lyrics-line")
            .data('lyric_id', this.id)
            .html([$startBlock, $endBlock, $contentBlock]);
    };

    updateNodeData() {
        super.updateNodeData();
        this.$element.find(".lyric-content").html(this.content);
        this.$element.find(".lyric-start").html(this.start);
        this.$element.find(".lyric-end").html(this.end);
    }


}

import Lyric from './Lyric';
import {createDOMElement} from "../Helpers/DOM";

export default class SyncLyric extends Lyric {

    constructor(record, selector) {
        super(record, selector);
        this.$element = this._createNode();
    }

    _createNode() {
        let $contentBlock = createDOMElement({classNames: 'lyric-content', content: this.content});
        let $startBlock = createDOMElement({classNames: ['timestamp', 'lyric-start'], content: this._start});
        let $endBlock = createDOMElement({classNames: ['timestamp', 'lyric-end'], content: this._end});

        return createDOMElement({classNames: 'lyric', content: [$startBlock, $endBlock, $contentBlock]})
            .data('lyric_id', this.id);
    };

    updateNodeData() {
        this.$element.attr('data-start', this._start);
        this.$element.attr('data-end', this._end);
        this.$element.find(".lyric-content").html(this.content);
        this.$element.find(".lyric-start").html(this._start);
        this.$element.find(".lyric-end").html(this._end);
    }


}

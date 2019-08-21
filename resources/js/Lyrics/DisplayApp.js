import BaseApp from './BaseApp';

export default class DisplayApp extends BaseApp {

    /**
     * @todo Implement lyric display by groups
     */

    eventHandlers = {
        load: [],
        ready: []
    };

    constructor(record, selector) {
        super(record, selector);
    }

    getLyricsForTime(timestamp) {
        return this.lyrics
            .sort((a, b) => a.start - b.start)
            .filter(item => {
                if (!item || (item && (!item.start || !item.end))) {
                    return;
                }
                return timestamp >= item.start && timestamp <= item.end;
            });
    }

    showLyricsForTime(timestamp) {

        let lyrics = this.getLyricsForTime(timestamp);

        if (!lyrics) {
            return this.releaseActive();
        }

        if (
            !this.activeLyrics ||
            this.activeLyrics.length !== lyrics.length ||
            this.activeLyrics.filter(lyric => lyrics.includes(lyric))
        ) {
            this.releaseActive();
            this.holdActive(lyrics);
        }

    }

    repaintActiveState() {
        super.repaintActiveState();
        this.#repositionContainer();
    }

    #repositionContainer() {
        if (!this.activeLyrics) {
            return;
        }

        let verticalFix = this.activeLyrics.reduce((sum, lyric) => sum + lyric.verticalPosition, 0);
        this.$container.css({
            "top": "calc(50vh - ${verticalFix}px )"
        });
    }

}

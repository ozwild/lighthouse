import LyricsService from './LyricsService';

export default class LyricsDisplayService extends LyricsService {

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
                return timestamp > item.start && timestamp < item.end;
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
            !this.activeLyrics.includes(lyrics)
        ) {
            this.releaseActive();
            this.holdActive(lyrics);
        }

    }

    showLyric(lyric) {

        if (!lyric) {
            return this.releaseActive();
        }

        if (
            !this.activeLyrics ||
            this.activeLyrics.length > 1 ||
            !this.activeLyrics.includes(lyric)
        ) {
            this.releaseActive();
            this.holdActive([lyric]);
        }
    }

    repaintActiveState() {
        super.repaintActiveState();
        this.repositionContainer();
    }

    repositionContainer() {
        if (!this.activeLyrics || this.activeLyrics.length === 0) {
            return;
        }

        let verticalFix = this.activeLyrics.reduce((sum, lyric) => sum + lyric.verticalPosition, 0);
        verticalFix += window.innerHeight / 2;

        this.$wrapper[0].scrollTo(0, verticalFix)

    }

}

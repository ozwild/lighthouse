import LyricsService from './LyricsService';

export default class LyricsDisplayService extends LyricsService {

    /**
     * @todo Implement lyric display by groups
     */

    scrollingCorrection = 0;

    eventHandlers = {
        load: [],
        ready: []
    };

    constructor(song, $container) {
        super(song, $container);
        this.trigger('load');
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

    getVerticalFixForActiveLyrics() {
        let activeLyricsFix = this.activeLyrics
            .reduce((sum, lyric) => sum + lyric.verticalPosition, 0);
        return activeLyricsFix - (window.innerHeight / 2) + this.scrollingCorrection;
    }

    repositionContainer() {
        if (!this.activeLyrics || this.activeLyrics.length === 0) {
            return;
        }

        window.scrollTo(0, this.getVerticalFixForActiveLyrics())

    }

}

import Eventful from '../Helpers/Eventful';
import {retrieveElementId} from "../Helpers/DOM";
import Lyric from "./Lyric";

export default class LyricsService extends Eventful {

    #record;
    $wrapper;
    $container;
    lyrics = [];
    selectedLyric;
    activeLyrics = [];

    constructor(record, selector) {

        super();

        this.#record = record;

        if (!selector) {
            throw "A valid DOM selector is required to initialize Lyrics Controls";
        }

        this.$wrapper = $(selector);
        this.$container = $("<div>").addClass("lyrics-content");
        this.$wrapper.append(this.$container);

    }

    get record() {
        return this.#record;
    }

    process() {
        this.lyrics = this.#record.lyrics.split("\n")
            .map(lyricText => new Lyric(lyricText));
    }

    toString() {
        return this.lyrics.map(lyric => lyric.toString()).join('\n');
    }

    render() {
        let content = this.lyrics.map(item => item.$element);
        this.$container.html(content);
    }

    getLyricById(id) {

        let result = this.lyrics
            .filter(item => item.id === id)
            .slice(0, 1);

        return result.length > 0 ?
            result[0] : null;

    }

    getFirstLyric() {
        return this.lyrics.length > 0 ? this.lyrics.slice(0, 1)[0] : null;
    }

    getNextLyricForSelection() {
        if (!this.selectedLyric) {
            return this.getFirstLyric();
        }
        let indexOfSelectedLyric = this.lyrics.indexOf(this.selectedLyric);
        return this.lyrics[indexOfSelectedLyric + 1];
    }

    getPreviousLyricForSelection() {
        if (!this.selectedLyric) {
            return this.getFirstLyric();
        }
        let indexOfSelectedLyric = this.lyrics.indexOf(this.selectedLyric);
        return this.lyrics[indexOfSelectedLyric - 1];
    }

    selectLyricByElement(element) {
        this.selectLyricById(retrieveElementId(element));
    }

    selectLyricById(id) {
        this.holdSelection(this.getLyricById(id));
    }

    selectNextLyric() {
        this.holdSelection(this.getNextLyricForSelection());
    }

    selectPreviousLyric() {
        this.holdSelection(this.getPreviousLyricForSelection())
    }

    holdSelection(lyric) {

        this.releaseSelection(false);

        if (lyric) {
            lyric.select();
            this.selectedLyric = lyric;
        }
        this.repaintSelectionState();
    }

    releaseSelection(repaint = true) {
        if (this.selectedLyric) {
            this.selectedLyric.deselect();
            this.selectedLyric = null;
        }
        if (repaint)
            this.repaintSelectionState();
    }

    holdActive(lyrics) {
        if (lyrics) {
            lyrics.forEach(lyric => lyric.activate());
            this.activeLyrics = lyrics;
        }
        this.repaintActiveState();
    }

    releaseActive() {
        if (this.activeLyrics) {
            this.activeLyrics.forEach(lyric => lyric.deactivate());
            this.activeLyrics = null;
        }
        this.repaintActiveState();
    }

    repaintSelectionState() {
        this.lyrics.forEach(lyric => lyric.repaintSelectionState());
    }

    repaintActiveState() {
        this.lyrics.forEach(lyric => lyric.repaintActiveState());
    }

}

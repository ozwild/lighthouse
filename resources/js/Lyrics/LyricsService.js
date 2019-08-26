import Eventful from '../Helpers/Eventful';
import {retrieveElementId} from "../Helpers/DOM";
import Lyric from "./Lyric";

export default class LyricsService extends Eventful {

    #record;
    $container;
    $content;
    lyrics = [];
    selectedLyric;
    activeLyrics = [];

    constructor(record, $container) {

        super();

        this.#record = record;

        this.$container = $container;
        this.$content = $("<div>").addClass("lyrics-content")
            .appendTo(this.$container);

    }

    get record() {
        return this.#record;
    }

    process() {
        if (!this.#record.lyrics) {
            this.lyrics.push(new Lyric("No lyrics available"));
        } else {
            this.lyrics = this.#record.lyrics.split("\n")
                .map(lyricText => new Lyric(lyricText));
        }
    }

    toString() {
        return this.lyrics.map(lyric => lyric.toString()).join('\n');
    }

    render() {
        let content = this.lyrics.map(item => item.$element);
        this.$content.html(content);
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

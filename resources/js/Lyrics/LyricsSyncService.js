import LyricsService from './LyricsService';
import SyncLyric from "./SyncLyric";

export default class LyricsSyncService extends LyricsService {

    eventHandlers = {
        load: [],
        ready: [],
        step: []
    };

    constructor(record, $container) {
        super(record, $container);
        this.#bindings();
        this.trigger('load');
    }

    #bindings() {

        let instance = this;

        window.addEventListener("keydown", e => {

            let keyCode = e.key.codePointAt(0);

            /*** Space Bar Key **/
            if (keyCode === 32 && e.target === document.body) {
                e.preventDefault();
            }

        });

        window.addEventListener("keyup", e => {

            let keyCode = e.key.codePointAt(0);

            /*** Space Bar Key **/
            if (keyCode === 32) {

                this.trigger("step");

                if (!this.selectedLyric) {
                    instance.selectNextLyric();
                }

            }

            /*** Esc Key **/
            if (keyCode === 69) {

                instance.releaseSelection();

            }
        });

        this.$container.on("click", ".lyric", event => {
            instance.selectLyricByElement(event.currentTarget);
        });

    };

    process() {
        this.lyrics = this.record.lyrics.split("\n")
            .map(lyricText => new SyncLyric(lyricText));
    }

    selectTimestamp(identifier) {
        if (!this.selectedLyric) {
            return;
        }
        this.selectedLyric.activeTimestampIdentifier = identifier;
        this.activeTimestampIdentifier = identifier;
        this._updateDOMWithTimestampSelection();
    }

    next(timestamp) {

        if (!this.selectedLyric || !timestamp) {
            return;
        }

        this.selectedLyric.updateTimestamp(timestamp);
        this.repaintSelectionState();

        if (!this.selectedLyric.activeTimestampIdentifier) {
            this.selectNextLyric();
            this.next(timestamp);
        }

    }


}
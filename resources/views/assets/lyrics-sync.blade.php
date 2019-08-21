@push('scripts')
    <script>
        class LyricsSyncHelper {

            #recordModel;
            containerSelector;
            $container;
            sourceContent;

            editingMode = false;
            lyrics = [];
            selectedLine;
            activeTimestamp;
            _lastTimestamp;

            TIMESTAMPS_IDENTIFIERS = {
                "START": Symbol('START'),
                "END": Symbol('END'),
            };

            #timestampRegularExpression = /(?:\[)([\d.]+)(?:])/;

            #eventHandlers = {
                step: []
            };

            constructor(containerSelector) {
                if (!containerSelector) {
                    throw "A valid DOM selector is required to initialize the Lyrics Sync Helper";
                }
                this.containerSelector = containerSelector;
                this.$container = $(this.containerSelector);
                this.#setKeyBindings();
            }

            on(eventName, event) {
                let list = this.#eventHandlers[eventName];
                if (list === undefined) {
                    throw "Unlisted event";
                }
                if (typeof event !== "function") {
                    throw "A function is expected as event handler";
                }
                list.push(event);
            }

            trigger(eventName, ...args) {
                let list = this.#eventHandlers[eventName];
                if (list === undefined) {
                    throw "Unlisted event";
                }

                list.forEach(handler => handler.apply(this, args));
            }

            set recordModel(record) {
                this.#recordModel = record;
                this.sourceContent = record.lyrics;
            }

            set source(lyrics) {
                this.sourceContent = lyrics;
            }

            get source() {
                return this.sourceContent;
            }

            get lyricsElements() {
                return this.lyrics.map(item => item.$element);
            }

            render() {
                this.$container.html(this.lyricsElements);
            }

            #createDOMElement = function (typeString, classString, content) {

                let $element = $("<" + typeString + ">", {
                    class: classString
                });

                $element.html(content);

                return $element;
            };

            #buildLine = function (actualLyricContent, startTimestampContent, endTimestampContent) {

                let $contentBlock = this.#createDOMElement("div", "lyric-content", actualLyricContent);
                let $startBlock = this.#createDOMElement("div", "timestamp lyric-start", startTimestampContent);
                let $endBlock = this.#createDOMElement("div", "timestamp lyric-end", endTimestampContent);

                return this.#createDOMElement("div", "lyrics-line")
                    .html([$startBlock, $endBlock, $contentBlock]);
            };

            process() {

                let lineSplits = this.sourceContent.split("\n");
                let instance = this;

                this.lyrics = lineSplits.map(lineText => {

                    let content, startTimestamp, endTimestamp;
                    let startTimestampMatches, endTimestampMatches;

                    startTimestampMatches = lineText.match(instance.#timestampRegularExpression);
                    content = lineText.replace(instance.#timestampRegularExpression, "").trim();

                    if (startTimestampMatches) {
                        startTimestamp = startTimestampMatches[1];
                    }

                    endTimestampMatches = content.match(instance.#timestampRegularExpression);
                    content = content.replace(instance.#timestampRegularExpression, "").trim();

                    if (endTimestampMatches) {
                        endTimestamp = endTimestampMatches[1];
                    }

                    let $line = instance.#buildLine(content, startTimestamp, endTimestamp);
                    let id = Symbol("line_id");

                    $line.data("line_id", id);

                    return {
                        id: id,
                        content: content,
                        startTimestamp: startTimestamp,
                        endTimestamp: endTimestamp,
                        $element: $line
                    }

                });

            }

            get output() {
                return this.lyrics.map(item => {
                    let start = "", end = "", content = item.content;
                    if (item.startTimestamp) {
                        start = "".concat("[", item.startTimestamp, "]");
                    }
                    if (item.endTimestamp) {
                        end = "".concat("[", item.endTimestamp, "]");
                    }
                    return start + end + content;
                }).join('\n');
            }

            getLineById(id) {
                let result = this.lyrics
                    .filter(item => item.id === id)
                    .slice(0, 1);
                return result.length > 0 ?
                    result[0] : null;
            }

            getFirstLine() {
                return this.lyrics.length > 0 ? this.lyrics.slice(0, 1)[0] : null;
            }

            getNextLine() {
                if (!this.selectedLine) {
                    return this.getFirstLine();
                }
                let indexOfSelectedLine = this.lyrics.indexOf(this.selectedLine);
                return this.lyrics[indexOfSelectedLine + 1];
            }

            getPreviousLine() {
                if (!this.selectedLine) {
                    throw "LyricsSyncHelper: Can't get the line before selection because there is no line currently selected";
                }
                let indexOfSelectedLine = this.lyrics.indexOf(this.selectedLine);
                return this.lyrics[indexOfSelectedLine - 1];
            }

            selectLineByElement(element) {
                let id = $(element).data('line_id');
                this.selectLineById(id);
            }

            selectLineById(id) {
                this.selectedLine = this.getLineById(id);
                this._updateDOMWithElementSelection();
            }

            selectNextLine() {
                this.selectedLine = this.getNextLine();
                this._updateDOMWithElementSelection();
            }

            selectPreviousLine() {
                this.selectedLine = this.getNextLine();
                this._updateDOMWithElementSelection();
            }

            unselectLine() {
                this.selectedLine = null;
                this.selectTimestamp(null);
                this._updateDOMWithElementSelection();
            }

            selectTimestamp(timestamp) {
                this.activeTimestamp = timestamp;
                this._updateDOMWithTimestampSelection();
            }

            next(timestamp) {

                if (!this.activeTimestamp || !timestamp) {
                    return;
                }

                switch (this.activeTimestamp) {

                    case this.TIMESTAMPS_IDENTIFIERS.START:
                        this.setLineStartTime(timestamp);
                        this.selectTimestamp(this.TIMESTAMPS_IDENTIFIERS.END);
                        return;

                    case this.TIMESTAMPS_IDENTIFIERS.END:
                        this.setLineEndTime(timestamp);
                        this.selectNextLine();
                        this.next(timestamp);
                        return;

                }

            }

            _resetSelectionHighlights() {
                this.$container.children().removeClass("selected");
            }

            _highlightSelection() {
                if (!this.selectedLine) {
                    return;
                }
                this.selectedLine.$element.addClass("selected");
            }

            _resetTimestampHighlights() {
                this.$container.find('.lyric-start, .lyric-end').removeClass("active");
            }

            _updateDOMWithElementSelection() {

                this._resetSelectionHighlights();

                let line = this.selectedLine;

                if (!line) {
                    return;
                }

                this._highlightSelection();

                /**
                 * Automatically select the Start Timestamp element
                 */
                this.selectTimestamp(this.TIMESTAMPS_IDENTIFIERS.START);

            };

            _updateDOMWithTimestampSelection() {

                this._resetTimestampHighlights();

                if (!this.selectedLine) {
                    return;
                }

                let $element = this.selectedLine.$element;
                let identifiers = this.TIMESTAMPS_IDENTIFIERS;

                switch (this.activeTimestamp) {

                    case identifiers.START:
                        $element.find('.lyric-start').addClass("active");
                        break;

                    case identifiers.END:
                        $element.find('.lyric-end').addClass("active");
                        break;

                }

            }

            #setKeyBindings = function () {

                let instance = this;

                window.addEventListener("keydown", e => {

                    let keyCode = e.key.codePointAt(0);

                    /**
                     * Space Bar Key
                     **/
                    if (keyCode === 32 && e.target === document.body) {
                        e.preventDefault();
                    }

                });

                window.addEventListener("keyup", e => {

                    let keyCode = e.key.codePointAt(0);

                    /**
                     * Space Bar Key
                     **/
                    if (keyCode === 32) {
                        this.trigger("step");
                        if (!this.selectedLine) {
                            this.selectNextLine();
                        }
                    }

                    /**
                     * Esc Key
                     **/
                    if (keyCode === 69) {
                        this.wrapUpLyric();
                        this.unselectLine();
                    }
                });
            };

            wrapUpLine() {
                if (!this.activeTimestamp ||
                    !this.selectedLine) {
                    return;
                }

                if (this.activeTimestamp === this.TIMESTAMPS_IDENTIFIERS.END &&
                    !this.selectedLine.endTimestamp) {
                    this.setLineEndTime(this._lastTimestamp);
                }
            }

            setLineStartTime(timestamp) {
                if (!this.selectedLine) {
                    return;
                }

                timestamp = +timestamp.toFixed(2);
                this.selectedLine.startTimestamp = timestamp;
                LyricsSyncHelper.updateDOMLine(this.selectedLine);
                this._lastTimestamp = timestamp;
            }

            setLineEndTime(timestamp) {
                if (!this.selectedLine) {
                    return;
                }
                timestamp = +timestamp.toFixed(2);
                this.selectedLine.endTimestamp = timestamp;
                LyricsSyncHelper.updateDOMLine(this.selectedLine);
                this._lastTimestamp = timestamp;
            }

            static updateDOMLine(element) {
                let $element = element.$element;
                $element.find(".lyric-start").html(element.startTimestamp);
                $element.find(".lyric-end").html(element.endTimestamp);
            }

        }
    </script>
@endpush
@push('scripts')
    <script>
        class LyricsHelper {

            #recordModel;
            containerSelector;
            $container;
            timestamps = [];
            sourceContent;
            htmlContent;
            lyrics = [];
            bufferTime = 1;
            groupMode = false;
            #timestampRegularExpression = /(?:\[)([\d.]+)(?:])/;
            #lyricsGroupSeparatorRegularExpression = /[\r\n]\s{2,}/g;
            #lyricsGroupSeparatorReplacement = '[break here]';
            #lineClass = "lyrics-line";
            #groupClass = "lyrics-block";

            #eventHandlers = {
                load: [],
                ready: []
            };

            static createDOMElement(typeString, classString, content, timestamp) {

                let $element = $("<" + typeString + ">", {
                    class: classString
                });

                $element.html(content);

                if (timestamp) {
                    $element.attr('data-timestamp', timestamp);
                }

                return $element;
            };

            #createLine = function (content, timestamp) {
                return LyricsHelper.createDOMElement("p", this.#lineClass, content, timestamp);
            };

            #createBlock = function (content, timestamp) {
                return LyricsHelper.createDOMElement("div", this.#groupClass, content, timestamp);
            };

            constructor(containerSelector) {
                if (!containerSelector) {
                    throw "A valid DOM selector is required to initialize the Lyrics Helper";
                }
                this.containerSelector = containerSelector;
                this.$container = $(this.containerSelector);
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

            set lyrics(lyrics) {
                this.sourceContent = lyrics;
                this.render();
            }

            get lyrics() {
                return this.sourceContent;
            }

            get lyricsElements() {
                return this.lyrics.map(item => item.$element);
            }

            render() {
                this.$container.html(this.lyricsElements);
            }

            processGroups(text) {
                let instance = this;
                text = text.replace(instance.#lyricsGroupSeparatorRegularExpression, instance.#lyricsGroupSeparatorReplacement);
                let groupSplits = text.split(instance.#lyricsGroupSeparatorReplacement);

                return groupSplits.map(function (blockText) {

                    let lines = instance.processLines(blockText);
                    let timestamp = lines.sort((a, b) => a.timestamp - b.timestamp)[0].timestamp;

                    let $contents = lines.map(line => line.$element);
                    let $element = instance.#createBlock($contents, timestamp);
                    $element.append($contents);

                    return {
                        lines: lines,
                        timestamp: timestamp,
                        $element: $element
                    }

                });
            };

            processLines(text) {

                let lineSplits = text.split("\n");
                let instance = this;

                return lineSplits.map(lineText => {

                    let content = lineText.replace(instance.#timestampRegularExpression, "").trim();
                    let timestampMatches = lineText.match(instance.#timestampRegularExpression);
                    let timestamp = timestampMatches ? parseFloat(timestampMatches[1]) : null;
                    let $element = instance.#createLine(content, timestamp);

                    return {
                        content: content,
                        timestamp: timestamp,
                        $element: $element
                    }

                });

            };

            process() {

                this.lyrics = this.groupMode ?
                    this.processGroups(this.sourceContent) :
                    this.processLines(this.sourceContent);

            }

            getElementForTime(time) {
                let result = this.lyrics
                    .sort((a, b) => a.timestamp - b.timestamp)
                    .filter(item => item.timestamp >= time)
                    .splice(0, 1);

                if (result.length === 0) {
                    return null;
                }

                return result[0];
            }

            showElementForTime(time) {

                time = time - this.bufferTime;

                let element = this.getElementForTime(time);

                if (!element) {
                    return;
                }

                let $element = element.$element;
                this.#resetHighlights();
                this.#highlightElement($element);
                this.#repositionContainer($element);
            }

            #resetHighlights = function () {
                this.$container.children().removeClass("active");
            };

            #highlightElement = function ($element) {
                if (!$element) {
                    return;
                }
                $element.addClass("active");
            };

            #repositionContainer = function ($element) {
                if (!$element) {
                    return;
                }
                if (!$element[0]) {
                    return;
                }

                let offset = $element[0].offsetTop;
                let height = $element.height() / 2;
                let correction = 0;

                let verticalAdjustment = height + offset + correction;

                this.$container.css({
                    "top": "calc(50vh - " + verticalAdjustment + "px )"
                });
            };

        }
    </script>
@endpush
import {timestampRX} from "../Lyrics/Constants";

export function encode(lyric) {
    let start = "", end = "", content = lyric.content;
    if (lyric.start) {
        start = "".concat("[", lyric.start, "]");
    }
    if (lyric.end) {
        end = "".concat("[", lyric.end, "]");
    }
    return start + end + content + "\n";
}

export function decode(text) {
    let content, startTimestamp, endTimestamp;
    let startTimestampMatches, endTimestampMatches;

    startTimestampMatches = text.match(timestampRX);
    if (startTimestampMatches) {
        startTimestamp = startTimestampMatches[1];
    }

    text = text.replace(timestampRX, "");

    endTimestampMatches = text.match(timestampRX);
    if (endTimestampMatches) {
        endTimestamp = endTimestampMatches[1];
    }

    content = text.replace(timestampRX, "");

    return {
        content: content,
        start: startTimestamp,
        end: endTimestamp
    }
}
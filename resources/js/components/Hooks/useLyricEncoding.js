const useLyricEncoding = () => {

    const timestampRX = /(?:\[)([\d.]+)(?:])/;

    function replaceRX(str) {
        return str.replace(timestampRX, "");
    }

    function getMatches(str) {
        let matches = str.match(timestampRX);
        return matches ? matches[1] : null;
    }

    const encode = ({start = null, end = null, content = ""}) => {
        start = "".concat("[", start, "] ");
        end = "".concat("[", end, "] ");
        return start + end + content;
    };

    const decode = str => {
        let start = getMatches(str);
        let end = getMatches(replaceRX(str));
        let content = replaceRX(replaceRX(str)).trim();

        return {
            content,
            start,
            end
        }
    };

    return {
        encode,
        decode
    }
};

export default useLyricEncoding;
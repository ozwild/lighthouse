import React, {Component} from 'react';
import useLyricEncoding from "../../Hooks/useLyricEncoding";

const {encode, decode} = useLyricEncoding();

class Lyric extends Component {

    static TYPES = {
        DISPLAY: Symbol(),
        SYNC: Symbol()
    };

    state = {
        start: null,
        end: null,
        content: "",
        type: Lyric.TYPES.DISPLAY
    };

    constructor(props) {
        super(props);
        let {start, end, content} = decode(this.props.text);
        this.state = {
            start, end, content,
            type: this.props.type
        };
    }

    render() {

        const {type, content, start, end} = this.state;

        if (type === Lyric.TYPES.SYNC) {
            return (
                <p className="lyric">
                    <span className="lyric-start">{start}</span>
                    <span className="lyric-end">{end}</span>
                    <span className="lyric-content">{content}</span>
                </p>
            );
        }

        return (
            <p className="lyric">
                {content}
            </p>
        );

    }
}

export default Lyric;
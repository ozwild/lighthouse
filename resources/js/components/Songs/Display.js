import React, {Component} from 'react';
import Lyric from "./Lyrics/Lyric";

class LyricsDisplay extends Component {
    render() {
        const {song} = this.props;
        const lyrics = song.lyrics.split("\n")
            .map((text, index) => <Lyric
                key={`${song.id}.${index}`}
                type={Lyric.TYPES.DISPLAY}
                text={text}/>);

        return (
            <div>
                <h1>{song.title}</h1>
                <div className="lyrics-container display">
                    <div className="lyrics-content">
                        {lyrics}
                    </div>
                </div>
            </div>
        );
    }
}

LyricsDisplay.defaultProps = {
    song: {
        id: null,
        lyrics: ""
    }
};

export default LyricsDisplay;
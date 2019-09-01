import React from 'react';
import useSearchSong from './Hooks/useSearchSong'

const SongSearch = () => {
    const {inputText, setInputText, search} = useSearchSong();
    return (
        <div className="input-field col s12">
            <input id="song-search" className="validate" type="text" value={inputText} onChange={e => setInputText(e.target.value)}/>
            <label htmlFor="song-search">Search for a song</label>
            <div>
                {search.loading && <div>...</div>}
                {search.error && <div>Error: {search.error.message}</div>}
                {search.result && (
                    <div>
                        <div>Results: {search.result.length}</div>
                        <ul>
                            {search.result.map(song => (
                                <li key={song.id}>{song.title}</li>
                            ))}
                        </ul>
                    </div>
                )}
            </div>
        </div>
    );
};

export default SongSearch;
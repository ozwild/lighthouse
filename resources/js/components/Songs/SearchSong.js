import React from 'react';
import PropTypes from 'prop-types';
import useSearchSong from "./Hooks/useSearchSong";

const SongSearch = (props) => {

    const {inputText, setInputText, search} = useSearchSong();

    return (
        <section className="search-box">
            <div className="input-field">
                <input autoFocus id="song-search" type="text" value={inputText}
                       onChange={e => setInputText(e.target.value)}/>
                <label htmlFor="song-search" className="label-icon">
                    <i className="material-icons">search</i>
                </label>
                <a className="close-icon grey-text" href="#" onClick={e => props.onDismiss()}><i
                    className="material-icons">clear</i></a>
                <div>
                    {search.error && <div>Error: {search.error.message}</div>}
                    {search.result && (
                        <div>
                            <div>Results: {search.result.length}</div>
                            <ul>
                                {search.result.map(song => (
                                    <li onClick={() => props.onSelect(song)}
                                        key={song.id}>{song.title}</li>
                                ))}
                            </ul>
                        </div>
                    )}
                </div>

            </div>
        </section>
    );
};

SongSearch.propTypes = {
    onSelect: PropTypes.func.isRequired
};

export default SongSearch;
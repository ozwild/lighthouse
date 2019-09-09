import React from 'react';
import PropTypes from 'prop-types';
import useForm from '../Hooks/useForm';
import {toast} from 'materialize-css';
import SongModel from "../../Models/SongModel";

let song;

const SongForm = (props) => {

    const {values, handleChange, handleSubmit, setValues} = useForm({
        initialValues: props.song,
        onSubmit({values}) {
            const song = new SongModel(values);
            song.save()
                .then(response => {
                    toast({html: "Song saved!", classes: "success"});
                    setValues(response);
                    props.onSave(song);
                });
        }
    });
    
    return (

        <div className="container">

            <h1>{!values.id ? "New Song" : values.title}</h1>

            <form id="song_form" className="form" onSubmit={handleSubmit}>

                <input type="hidden" value={values.id || ''} onChange={handleChange}/>

                <section className="row">

                    <div className="input-field col s12 m6">
                        <input id="title" className="validate" type="text" name="title"
                               value={values.title || ''} onChange={handleChange}/>
                        <label htmlFor="title">Title</label>
                    </div>

                    <div className="input-field col s12 m6">
                        <input id="artist" className="validate" type="text" name="artist"
                               value={values.artist || ''} onChange={handleChange}/>
                        <label htmlFor="artist">Artist</label>
                    </div>

                    <div className="input-field col s12 m6">
                        <input id="key" className="validate" type="text" name="key"
                               value={values.key || ''} onChange={handleChange}/>
                        <label htmlFor="key">Key</label>
                    </div>

                    <div className="input-field col s12 m6">
                        <input id="youtube_id" className="validate" type="text" name="youtube_id"
                               value={values.youtube_id || ''} onChange={handleChange}/>
                        <label htmlFor="youtube_id">Youtube Video Id</label>
                    </div>

                    <div className="input-field col s12 m6">
                        <input id="video_start" className="validate" type="number" step="0.1" name="video_start"
                               value={values.video_start || ''} onChange={handleChange}/>
                        <label htmlFor="video_start">Video Start</label>
                    </div>

                    <div className="input-field col s12 m6">
                        <input id="video_end" className="validate" type="number" step="0.1" name="video_end"
                               value={values.video_end || ''} onChange={handleChange}/>
                        <label htmlFor="video_end">Video End</label>
                    </div>

                </section>

                <section className="row">
                    <div className="col s12">

                        <div className="input-field">
                                <textarea id="lyrics"
                                          className="materialize-textarea"
                                          name="lyrics"
                                          rows="15" value={values.lyrics || ''} onChange={handleChange}>
                                </textarea>
                            <label htmlFor="lyrics">Lyrics</label>
                        </div>

                    </div>
                </section>

                <footer className="row">
                    <div className="input-field col s12">
                        <button type="submit" className="btn btn-large waves-effect waves-light right">
                            Save
                            <i className="material-icons left">send</i>
                        </button>
                        <div className="clearfix">
                        </div>
                    </div>
                </footer>

            </form>
        </div>
    );
};

SongForm.propTypes = {
    onSave: PropTypes.func.isRequired
};

export default SongForm;
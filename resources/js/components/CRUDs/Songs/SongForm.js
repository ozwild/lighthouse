import React, {Component} from 'react';
import {SectionTitle} from '../../Partials/Titles';
import SongModel from '../../../Models/SongModel';
import SongSearch from "./SearchSong";
import useForm from '../../Hooks/useForm';
import {toast} from 'materialize-css';

const SongForm = () => {

    const {values, handleChange, handleSubmit, setValues} = useForm({
        initialValues: new SongModel(),
        onSubmit({values}) {
            SongModel.newFromData(values)
                .save()
                .then(response => {
                    toast({html: "Song saved!", classes: "success"});
                    setValues(response);
                });
        }
    });

    return (
        <div className="container">

            <SectionTitle title={"New Song"}/>

            <section className="row">
                <SongSearch/>
            </section>

            <form id="song_form" className="form" onSubmit={handleSubmit}>

                <input type="hidden" value={values.id} onChange={handleChange}/>

                <section className="row">

                    <div className="input-field col s12 m6">
                        <input id="title" className="validate" type="text" name="title"
                               value={values.title} onChange={handleChange}/>
                        <label htmlFor="title">Title</label>
                    </div>

                    <div className="input-field col s12 m6">
                        <input id="artist" className="validate" type="text" name="artist"
                               value={values.artist} onChange={handleChange}/>
                        <label htmlFor="artist">Artist</label>
                    </div>

                    <div className="input-field col s12 m6">
                        <input id="artist" className="validate" type="text" name="key"
                               value={values.key} onChange={handleChange}/>
                        <label htmlFor="key">Key</label>
                    </div>

                    <div className="input-field col s12 m6">
                        <input id="youtube_id" className="validate" type="text" name="youtube_id"
                               value={values.youtube_id} onChange={handleChange}/>
                        <label htmlFor="youtube_id">Youtube Video Id</label>
                    </div>

                    <div className="input-field col s12 m6">
                        <input id="video_start" className="validate" type="number" step="0.1" name="video_start"
                               value={values.video_start} onChange={handleChange}/>
                        <label htmlFor="video_start">Video Start</label>
                    </div>

                    <div className="input-field col s12 m6">
                        <input id="video_end" className="validate" type="number" step="0.1" name="video_end"
                               value={values.video_end} onChange={handleChange}/>
                        <label htmlFor="video_end">Video End</label>
                    </div>

                </section>

                <section className="row">
                    <div className="col s12">
                        <div className="flex">
                            <div className="input-field flex-2">
                                <textarea id="lyrics"
                                          className="materialize-textarea"
                                          name="lyrics"
                                          rows="15" value={values.lyrics} onChange={handleChange}>
                                </textarea>
                                <label htmlFor="lyrics">Lyrics</label>
                            </div>
                            <div className="flex-1">
                                <div className="clearfix">
                                </div>
                            </div>
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

export default SongForm;
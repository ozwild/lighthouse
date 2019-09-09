import axios from 'axios';
import SongModel from "../Models/SongModel";

export default class SongService {

    /**
     * @param query {string}
     * @returns {Promise<string|SpeechRecognitionResultList>|null}
     */
    static async searchSong(query) {

        if (!query) {
            return;
        }

        const response = await axios.get(`/api/songs/search?query=${encodeURIComponent(query)}`);
        const {data} = await response;
        return data.results.map(songData => new SongModel(songData));
    }

    /**
     * @param id {int}
     * @returns {Promise<SongModel | Promise<SongModel | never>>}
     */
    static async get(id) {
        return axios.get(`/api/songs/${id}`)
            .then(response => {
                return SongService.build(response.data);
            }).catch(error => {
                console.error(error);
                return error;
            });
    }

    /**
     *
     * @param data {Object}
     * @returns {SongModel}
     */
    static build(data) {
        return new SongModel(data);
    }

    /**
     * @param song {SongModel}
     * @returns {Promise<AxiosResponse<any>|never>}
     */
    static save(song) {
        return song.isANewSong ?
            this.#store(song) :
            this.#update(song);
    }

    /**
     * @param song SongModel
     * @returns {Promise<AxiosResponse<any> | never>}
     */
    static #store(song) {
        return axios.post('/api/songs', song)
            .then(response => response.data);
    }

    /**
     * @param song {SongModel}
     * @returns {Promise<AxiosResponse<any> | never>}
     */
    static #update(song) {
        return axios.put('/api/songs/' + song.id, song)
            .then(response => response.data);
    }

}
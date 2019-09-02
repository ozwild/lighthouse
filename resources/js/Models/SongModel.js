import axios from 'axios';

export default class SongModel {
    id = '';
    title = '';
    key = '';
    artist = '';
    album = '';
    youtube_id = '';
    video_start = '';
    video_end = '';
    artist_id = '';
    album_id = '';
    lyrics = '';

    static async searchSong(query) {

        if (!query) {
            return;
        }

        const response = await axios.get(`/api/songs/search?query=${encodeURIComponent(query)}`);
        const {data} = await response;
        return data.results;
    }

    static newFromData(data) {
        let model = new SongModel();
        model.fill(data);
        return model;
    }

    fill(data) {
        Object.keys(this).forEach(field => this[field] = data[field]);
        return this;
    }

    get isANewRecord() {
        return !this.id;
    }

    save() {
        return this.isANewRecord ?
            this._store() :
            this._update();
    }

    _store() {
        return axios.post('/api/songs', this)
            .then(response => response.data);
    }

    _update() {
        return axios.put('/api/songs/' + this.id, this)
            .then(response => response.data);
    }

}
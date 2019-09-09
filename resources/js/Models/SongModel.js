import SongService from "../Services/SongService";

export default class SongModel {

    id;
    title = "";
    key = "";
    artist = "";
    album = "";
    youtube_id = "";
    video_start = "";
    video_end = "";
    artist_id;
    album_id;
    lyrics = "";

    /**
     * @param data {Object}
     */
    constructor(data = {}) {
        Object.keys(data)
            .forEach(key => {
                const value = data[key];
                if (this.hasOwnProperty(key) && value) {
                    this[key] = value;
                }
            });
    }

    /**
     * @param data {Object}
     * @returns {SongModel}
     */
    fill(data) {
        Object.keys(data)
            .forEach(key => {
                const value = data[key];
                if (this.hasOwnProperty(key) && value) {
                    this[key] = value;
                }
            });
        return this;
    }

    /**
     * @returns {boolean}
     */
    get isANewSong() {
        return !this.id;
    }

    /**
     * @returns {Promise<AxiosResponse<any>|never>}
     */
    save() {
        return SongService.save(this)
            .then(songData => this.fill(songData));
    }

}
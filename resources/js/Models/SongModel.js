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

    static async searchSong(query, abortSignal) {

        if (!query) {
            return;
        }

        let result = await fetch(
            `/api/songs/search?query=${encodeURIComponent(query)}`,
            {
                signal: abortSignal,
            });

        if (result.status !== 200) {
            throw new Error('bad status = ' + result.status);
        }

        const json = await result.json();
        return json.results;
    }

    constructor(data = {}) {
        Object.keys(SongModel).forEach(field => this[field] = data[field]);
    }

    get isANewRecord() {
        return !this.id;
    }

    save() {

        let options = {
            data: this
        };

        if (this.isANewRecord) {
            options.action = "/api/songs/store";
            options.method = "POST";
        } else {
            options.action = `/api/songs/${this.id}`;
            options.method = "PUT";
        }

        $.ajax(options).done(data => console.log(data));
    }

}
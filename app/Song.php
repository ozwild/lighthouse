<?php

namespace App;

use Eloquent;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Carbon;

/**
 * App\Record
 *
 * @property int $id
 * @property string|null $artist
 * @property string $name
 * @property string|null $youtube_id
 * @property int $video_start
 * @property string|null $lyrics
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @method static Builder|Song newModelQuery()
 * @method static Builder|Song newQuery()
 * @method static Builder|Song query()
 * @method static Builder|Song whereArtist($value)
 * @method static Builder|Song whereCreatedAt($value)
 * @method static Builder|Song whereId($value)
 * @method static Builder|Song whereLyrics($value)
 * @method static Builder|Song whereName($value)
 * @method static Builder|Song whereUpdatedAt($value)
 * @method static Builder|Song whereVideoStart($value)
 * @method static Builder|Song whereYoutubeId($value)
 * @mixin Eloquent
 */
class Song extends Model
{
    protected $fillable = [
        'title', 'artist', 'album', 'artist_id', 'album_id',
        'key', 'lyrics',
        'youtube_id', 'video_start', 'video_end',
        'spotify_id', 'spotify_album_id', 'spotify_artist_id', 'spotify_uri', 'spotify_href'
    ];

}

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
 * @method static Builder|Record newModelQuery()
 * @method static Builder|Record newQuery()
 * @method static Builder|Record query()
 * @method static Builder|Record whereArtist($value)
 * @method static Builder|Record whereCreatedAt($value)
 * @method static Builder|Record whereId($value)
 * @method static Builder|Record whereLyrics($value)
 * @method static Builder|Record whereName($value)
 * @method static Builder|Record whereUpdatedAt($value)
 * @method static Builder|Record whereVideoStart($value)
 * @method static Builder|Record whereYoutubeId($value)
 * @mixin Eloquent
 */
class Record extends Model
{
    protected $fillable = [
        'name', 'artist', 'youtube_id', 'video_start', 'lyrics'
    ];

}

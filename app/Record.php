<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Record extends Model
{
    protected $fillable = [
        'name', 'artist', 'video', 'lyrics'
    ];



}

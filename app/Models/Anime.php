<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Anime extends Model
{
    use HasFactory;
    protected $guarded = [];
    protected $fillable = ['title', 'slug', 'description', 'studio', 'genres', 'duration', 'images', 'user'];

    public function studio()
    {
        return $this->belongsTo(Studio::class, 'studio');
    }

    public function getGenresAttribute($value)
    {
        return Genre::whereIn('id', json_decode($value))->get();
    }
}

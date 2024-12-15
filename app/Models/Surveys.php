<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Spatie\Sluggable\HasSlug;
use Spatie\Sluggable\SlugOptions;

class Surveys extends Model
{
    use HasFactory, Notifiable, HasApiTokens, HasSlug;

    protected $fillable = [
        'title',
        'description',
        'user_id',
        'status',
        'slug',
        'expires_date',
        'image',
        'created_at',
        'updated_at'
    ];

    public function getSlugOptions(): SlugOptions
    {
        return SlugOptions::create()
            ->generateSlugsFrom('name')
            ->saveSlugsTo('slug');
    }
}

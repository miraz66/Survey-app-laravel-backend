<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class Surveys extends Model
{
    use HasFactory, Notifiable, HasApiTokens;

    protected $fillable = [
        'title',
        'description',
        'user_id',
        'status',
        'slug',
        'expire_at',
        'image',
        'type',
        'questions'
    ];
}

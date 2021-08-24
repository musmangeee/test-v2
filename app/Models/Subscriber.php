<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;

class Subscriber extends Model
{
    use HasFactory, Notifiable;

    protected $fillable = ['name', 'email'];

    public function posts()
    {
        return $this->belongsToMany(Post::class, 'mailing_lists');
    }
}

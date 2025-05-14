<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Note extends Model
{
    protected $fillable = [
        'user_id', 'title', 'background_color', 'is_pinned'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // public function items()
    // {
    //     return $this->hasMany(NoteItem::class);
    // }
}

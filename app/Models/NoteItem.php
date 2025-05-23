<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class NoteItem extends Model
{
    use HasFactory;

    protected $fillable = [
        'note_id',
        'content',
    ];

    protected $casts = [
        'content' => 'array',
    ];

    public function note()
    {
        return $this->belongsTo(Note::class);
    }
}

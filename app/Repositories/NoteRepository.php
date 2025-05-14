<?php

namespace App\Repositories;

use App\Models\Note;

class NoteRepository
{
    public function getAllByUser($userId)
    {
        return Note::where('user_id', $userId)->latest()->get();
    }

    public function create(array $data)
    {
        return Note::create($data);
    }

    public function update($id, array $data)
    {
        $note = Note::findOrFail($id);
        $note->update($data);
        return $note;
    }

    public function delete($id)
    {
        $note = Note::findOrFail($id);
        return $note->delete();
    }

    public function findByIdAndUser($id, $userId)
    {
        return Note::where('id', $id)->where('user_id', $userId)->firstOrFail();
    }
}

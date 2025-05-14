<?php

namespace App\Repositories;

use App\Models\NoteItem;
use Illuminate\Support\Facades\DB;

class NoteItemRepository
{
    public function create(array $data)
    {
        $noteItem = new NoteItem();
        $noteItem->note_id = $data['note_id'];

        $content = $data['content'];

        $noteItem->content = json_encode($content);
        $noteItem->save();

        return $noteItem;
    }

    public function findById($id)
    {
        return NoteItem::findOrFail($id);
    }

    public function update($id, array $data)
    {
        $noteItem = $this->findById($id);

        $content = json_decode($noteItem->content, true);
        $content['item'] = $data['item'];
        $content['is_checklist'] = $data['is_checklist'];
        $content['children'] = $data['children'];

        $noteItem->content = json_encode($content);
        $noteItem->save();

        return $noteItem;
    }

    public function delete($id)
    {
        $noteItem = $this->findById($id);
        $noteItem->delete();
    }

    public function getAllByNoteId($noteId)
    {
        return NoteItem::where('note_id', $noteId)->get();
    }

    public function getNoteById($noteId)
    {
        return NoteItem::where('note_id', $noteId)->first();
        
    }
}

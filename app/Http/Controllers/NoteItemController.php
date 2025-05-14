<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Repositories\NoteItemRepository;

class NoteItemController extends Controller
{
    protected $noteItemRepo;

    public function __construct()
    {
        $this->noteItemRepo = new NoteItemRepository();
    }

    public function index($noteId)
    {
        $noteItems = $this->noteItemRepo->getAllByNoteId($noteId);
        
        return response()->json([
            'status' => 'success',
            'message' => 'Fetched all note items successfully.',
            'data' => $noteItems
        ]);
    }

    public function store(Request $request, $noteId)
    {
        $data = $request->validate([
            'content' => 'required|array',
            'content.*.item' => 'required|string|max:255',
            'content.*.is_checked' => 'required|boolean',
            'content.*.children' => 'nullable|array',
            'content.*.children.*.item' => 'required|string|max:255',
            'content.*.children.*.id' => 'required|integer',
            'content.*.children.*.is_checked' => 'required|boolean',
        ]);

        $data['note_id'] = $noteId;

        $noteItem = $this->noteItemRepo->create($data);

        return response()->json([
            'status' => 'success',
            'message' => 'Note item created successfully.',
            'data' => $noteItem
        ], 201);
    }

    public function getItemDetail($noteId, $childId)
    {
        $noteItem = $this->noteItemRepo->getNoteById($noteId);

        if (!$noteItem) {
            return response()->json([
                'status' => 'error',
                'message' => 'Note not found.',
            ], 404);
        }

        $content = json_decode($noteItem->content, true);

        foreach ($content as $parentItem) {
            foreach ($parentItem['children'] as $childItem) {
                if ($childItem['id'] == $childId) {
                    return response()->json([
                        'status' => 'success',
                        'message' => 'Item found.',
                        'data' => $childItem,
                    ], 200);
                }
            }
        }

        return response()->json([
            'status' => 'error',
            'message' => 'Item not found.',
        ], 404);
    }

    public function deleteChildItem($noteId, $childId)
    {
        $noteItem = $this->noteItemRepo->getNoteById($noteId);

        if (!$noteItem) {
            return response()->json([
                'status' => 'error',
                'message' => 'Note not found.',
            ], 404);
        }

        $content = json_decode($noteItem->content, true);

        $found = false;
        foreach ($content as &$parentItem) {
            if (isset($parentItem['children'])) {
                foreach ($parentItem['children'] as $key => $childItem) {
                    if ($childItem['id'] == $childId) {
                        unset($parentItem['children'][$key]);
                        $found = true;
                        break 2;
                    }
                }
            }
        }

        if (!$found) {
            return response()->json([
                'status' => 'error',
                'message' => 'Child item not found.',
            ], 404);
        }

        $noteItem->content = json_encode($content);
        $noteItem->save();

        return response()->json([
            'status' => 'success',
            'message' => 'Child item deleted successfully.',
            'data' => $noteItem,
        ], 200);
    }


    public function destroy($id)
    {
        $this->noteItemRepo->delete($id);

        return response()->json([
            'status' => 'success',
            'message' => 'Note item deleted successfully.'
        ]);
    }
}

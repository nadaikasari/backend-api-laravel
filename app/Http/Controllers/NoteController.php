<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Repositories\NoteRepository;

class NoteController extends Controller
{
    protected $noteRepo;

    public function __construct()
    {
        $this->noteRepo = new NoteRepository();
    }

    public function index(Request $request)
    {
        $notes = $this->noteRepo->getAllByUser($request->user()->id);

        return response()->json([
            'status' => true,
            'message' => 'Notes retrieved successfully',
            'data' => $notes
        ], 200);
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'title' => 'required|string|max:255',
            'background_color' => 'nullable|string|max:7',
            'is_pinned' => 'boolean',
        ]);

        $data['user_id'] = $request->user()->id;
        $note = $this->noteRepo->create($data);

        return response()->json([
            'status' => true,
            'message' => 'Note created successfully',
            'data' => $note
        ], 201);
    }

    public function update(Request $request, $id)
    {
        $data = $request->validate([
            'title' => 'required|string|max:255',
            'background_color' => 'nullable|string|max:7',
            'is_pinned' => 'boolean',
        ]);

        $note = $this->noteRepo->findByIdAndUser($id, $request->user()->id);

        if (!$note) {
            return response()->json([
                'status' => false,
                'message' => 'Note not found',
                'data' => null
            ], 404);
        }

        $updated = $this->noteRepo->update($note->id, $data);

        return response()->json([
            'status' => true,
            'message' => 'Note updated successfully',
            'data' => $updated
        ], 200);
    }

    public function destroy(Request $request, $id)
    {
        $note = $this->noteRepo->findByIdAndUser($id, $request->user()->id);

        if (!$note) {
            return response()->json([
                'status' => false,
                'message' => 'Note not found',
                'data' => null
            ], 404);
        }

        $this->noteRepo->delete($note->id);

        return response()->json([
            'status' => true,
            'message' => 'Note deleted successfully',
            'data' => null
        ], 200);
    }
}
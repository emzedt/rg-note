<?php

namespace App\Http\Controllers;

use App\Models\Note;
use Illuminate\Http\Request;

class CommentController extends Controller
{
    public function store(Request $request, Note $note)
    {
        $validated = $request->validate(['body' => 'required|string']);
        $note->comments()->create([
            'body' => $validated['body'],
            'user_id' => auth()->id()
        ]);
        return back()->with('success', 'Komentar ditambahkan!');
    }
}

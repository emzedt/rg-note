<?php

namespace App\Http\Controllers;

use App\Models\Comment;
use App\Models\Note;
use App\Jobs\SendNoteCommentNotification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class CommentController extends Controller
{
    public function store(Request $request, $noteId)
    {
        $request->validate([
            'body' => 'required|string|max:255',
        ]);

        $note = Note::findOrFail($noteId);
        $comment = new Comment();
        $comment->note_id = $note->id;
        $comment->user_id = $request->user()->id;
        $comment->body = $request->input('body');
        $comment->save();


        // Dispatch job untuk kirim email ke author note
        if ($note->user && $note->user->email) {
            SendNoteCommentNotification::dispatch($note, $comment, $request->user());
        }

        return back()->with('success', 'Comment posted and author notified!');
    }
}

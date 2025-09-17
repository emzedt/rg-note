<?php

namespace App\Livewire;

use App\Models\Comment;
use App\Models\Note;
use Livewire\Component;

class NoteComments extends Component
{
    public Note $note;
    public $commentText = '';

    public function mount(Note $note)
    {
        $this->note = $note;
    }

    public function addComment()
    {
        $this->validate([
            'commentText' => 'required|string|min:2'
        ]);

        Comment::create([
            'note_id' => $this->note->id,
            'user_id' => auth()->id(),
            'body' => $this->commentText
        ]);

        $this->reset('commentText');
        $this->note->refresh();
    }

    public function deleteComment($commentId)
    {
        $comment = Comment::findOrFail($commentId);

        // Only comment owner or note owner can delete
        if (auth()->id() === $comment->user_id || auth()->id() === $this->note->user_id) {
            $comment->delete();
            $this->note->refresh();
        }
    }

    public function render()
    {
        return view('livewire.note-comments', [
            'comments' => $this->note->comments
        ]);
    }
}

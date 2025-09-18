<?php

namespace App\Mail;

use App\Models\Note;
use App\Models\User;
use App\Models\Comment;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class NoteCommentNotification extends Mailable
{
    use Queueable, SerializesModels;

    public $note;
    public $comment;
    public $commenter;

    public function __construct(Note $note, Comment $comment, User $commenter)
    {
        $this->note = $note;
        $this->comment = $comment;
        $this->commenter = $commenter;
    }

    public function build()
    {
        return $this->subject('New Comment on Your Note')
            ->markdown('emails.note-comment')
            ->with([
                'note' => $this->note,
                'comment' => $this->comment,
                'commenter' => $this->commenter,
            ]);
    }
}

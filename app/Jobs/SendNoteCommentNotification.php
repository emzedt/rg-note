<?php

namespace App\Jobs;

use App\Mail\NoteCommentNotification;
use App\Models\Note;
use App\Models\Comment;
use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Mail;

class SendNoteCommentNotification implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public $note, $comment, $commenter;

    public function __construct(Note $note, Comment $comment, User $commenter)
    {
        $this->note = $note;
        $this->comment = $comment;
        $this->commenter = $commenter;
    }

    public function handle()
    {
        Mail::to($this->note->user->email)
            ->send(new NoteCommentNotification($this->note, $this->comment, $this->commenter));
    }
}

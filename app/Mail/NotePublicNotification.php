<?php

namespace App\Mail;

use App\Models\Note;
use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class NotePublicNotification extends Mailable
{
    use Queueable, SerializesModels;

    public $note;
    public $author;

    public function __construct(Note $note, User $author)
    {
        $this->note = $note;
        $this->author = $author;
    }

    public function build()
    {
        return $this->subject('A Note is Now Public!')
            ->markdown('emails.note-public')
            ->with([
                'note' => $this->note,
                'author' => $this->author,
            ]);
    }
}

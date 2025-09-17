<?php

// app/Mail/NoteSharedNotification.php
namespace App\Mail;

use App\Models\Note;
use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class NoteSharedNotification extends Mailable
{
    use Queueable, SerializesModels;

    public function __construct(
        public Note $note,
        public User $inviter,
        public string $role
    ) {}

    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Anda diundang untuk berkolaborasi pada sebuah catatan',
        );
    }

    public function content(): Content
    {
        return new Content(
            markdown: 'emails.note-shared',
        );
    }
}

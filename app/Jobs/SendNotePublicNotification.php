<?php

namespace App\Jobs;

use App\Mail\NotePublicNotification;
use App\Models\Note;
use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Mail;

class SendNotePublicNotification implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public $note;
    public $author;
    public $user;

    public function __construct(Note $note, User $author, User $user)
    {
        $this->note = $note;
        $this->author = $author;
        $this->user = $user;
    }

    public function handle()
    {
        Mail::to($this->user->email)
            ->send(new NotePublicNotification($this->note, $this->author));
    }
}

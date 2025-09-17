<?php

namespace App\Jobs;

use App\Mail\NoteSharedNotification;
use App\Models\Note;
use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Mail;

class SendNoteInvitationEmail implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public function __construct(
        protected User $invitedUser,
        protected Note $note,
        protected User $inviter,
        protected string $role
    ) {}

    public function handle(): void
    {
        $mailable = new NoteSharedNotification($this->note, $this->inviter, $this->role);
        Mail::to($this->invitedUser->email)->send($mailable);
    }
}

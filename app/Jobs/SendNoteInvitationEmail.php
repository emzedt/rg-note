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

    protected Note $note;
    protected User $invitedUser;
    protected string $role;

    public function __construct(Note $note, User $invitedUser)
    {
        $this->note = $note;
        $this->invitedUser = $invitedUser;
        $this->role = $note->sharedWithUsers()->where('users.id', $invitedUser->id)->first()->pivot->role ?? 'viewer';
    }

    public function handle(): void
    {
        $inviter = User::find($this->note->user_id);
        $mailable = new NoteSharedNotification($this->note, $inviter, $this->role);
        Mail::to($this->invitedUser->email)->send($mailable);
    }
}

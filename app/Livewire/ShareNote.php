<?php

namespace App\Livewire;

use App\Jobs\SendNoteInvitationEmail;
use App\Models\Note;
use App\Models\User;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Livewire\Component;

class ShareNote extends Component
{
    use AuthorizesRequests;

    public Note $note;
    public $email = '';
    public $role = 'viewer';
    public $sharedUsers = [];

    public function mount(Note $note)
    {
        $this->note = $note;
        $this->authorize('update', $note);
        $this->loadSharedUsers();
    }

    public function loadSharedUsers()
    {
        $this->sharedUsers = $this->note->sharedWithUsers()->get();
    }

    public function shareWithUser()
    {
        $this->validate([
            'email' => 'required|email|exists:users,email',
            'role' => 'required|in:viewer,editor',
        ]);

        $user = User::where('email', $this->email)->first();

        // Don't share with the owner
        if ($user->id === $this->note->user_id) {
            session()->flash('error', 'You cannot share a note with yourself.');
            return;
        }

        // Check if already shared
        if ($this->note->sharedWithUsers()->where('users.id', $user->id)->exists()) {
            // Update role if different
            $currentRole = $this->note->sharedWithUsers()->where('users.id', $user->id)->first()->pivot->role;
            if ($currentRole !== $this->role) {
                $this->note->sharedWithUsers()->updateExistingPivot($user->id, ['role' => $this->role]);
                session()->flash('message', 'User role updated successfully.');
            } else {
                session()->flash('error', 'Note already shared with this user.');
            }
        } else {
            // Share note with user
            $this->note->sharedWithUsers()->attach($user->id, ['role' => $this->role]);

            // Send email notification
            SendNoteInvitationEmail::dispatch($this->note, $user);

            session()->flash('message', 'Note shared successfully.');
        }

        $this->reset('email');
        $this->loadSharedUsers();
    }

    public function removeSharedUser($userId)
    {
        $this->note->sharedWithUsers()->detach($userId);
        session()->flash('message', 'User removed successfully.');
        $this->loadSharedUsers();
    }

    public function updateUserRole($userId, $newRole)
    {
        $this->note->sharedWithUsers()->updateExistingPivot($userId, ['role' => $newRole]);
        session()->flash('message', 'User role updated successfully.');
        $this->loadSharedUsers();
    }

    public function render()
    {
        return view('livewire.share-note');
    }
}

<?php

namespace App\Policies;

use App\Models\Note;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class NotePolicy
{
    /**
     * Determine whether the user can view any models.
     */
    protected $policies = [
        Note::class => NotePolicy::class,
    ];

    public function viewAny(User $user): bool
    {
        return false;
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, Note $note): bool
    {
        // User boleh lihat jika dia pemilik ATAU catatan itu publik ATAU di-share ke dia
        return $note->is_public || $user->id === $note->user_id || $note->sharedWithUsers->contains($user);
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
        return false;
    }

    public function show(Note $note)
    {
        $this->authorize('view', $note); // Baris ini menggantikan if-else yang panjang
        return view('notes.show', compact('note'));
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, Note $note): bool
    {
        // Izinkan jika user adalah pemilik ATAU dia adalah editor
        if ($user->id === $note->user_id) {
            return true;
        }

        // Cek peran di tabel pivot
        $sharedUser = $note->sharedWithUsers()->where('user_id', $user->id)->first();
        return $sharedUser && $sharedUser->pivot->role === 'editor';
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, Note $note): bool
    {
        // Hanya pemilik yang boleh delete
        return $user->id === $note->user_id;
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user, Note $note): bool
    {
        return false;
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user, Note $note): bool
    {
        return false;
    }
}

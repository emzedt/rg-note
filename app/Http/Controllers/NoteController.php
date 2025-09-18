<?php

namespace App\Http\Controllers;

use App\Jobs\SendNoteInvitationEmail;
use App\Jobs\SendNotePublicNotification;
use App\Models\Note;
use App\Models\NoteViewHistory;
use App\Models\User;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class NoteController extends Controller
{
    use AuthorizesRequests;

    public function index(Request $request)
    {
        $filter = $request->query('filter', 'private'); // Default ke 'private'
        $user = auth()->user();
        $notes = collect(); // Inisialisasi koleksi kosong

        switch ($filter) {
            case 'shared':
                $notes = auth()->user()->sharedNotes()->latest()->get();
                break;
            case 'public':
                $notes = Note::where('is_public', true)->latest()->get();
                break;
            case 'private':
                $notes = $user->notes()->where('is_public', false)->latest()->get();
                break;
            default:
                $notes = $user->notes()->latest()->get();
                break;
        }

        return view('notes.index', compact('notes', 'filter'));
    }

    // public function create()
    // {
    //     return view('notes.create');
    // }

    // public function store(Request $request)
    // {
    //     $validated = $request->validate([
    //         'title' => 'required|string|max:255',
    //         'content' => 'required|string',
    //     ]);

    //     $request->user()->notes()->create($validated);

    //     return redirect()->route('notes.index')->with('success', 'Catatan berhasil dibuat!');
    // }

    public function show(Note $note)
    {
        // Otorisasi: hanya pemilik atau yang di-share boleh lihat
        abort_if(!$note->is_public && $note->user_id !== auth()->id() && !$note->sharedWithUsers->contains(auth()->id()), 403);

        NoteViewHistory::updateOrCreate(
            [
                'user_id' => auth()->id(),
                'note_id' => $note->id,
            ],
            [
                'updated_at' => now(),
            ]
        );

        $note->load('sharedWithUsers');

        return view('notes.show', compact('note'));
    }

    /**
     * Remove the specified resource from storage.
     */
    // public function destroy(Note $note)
    // {
    //     $this->authorize('delete', $note);
    //     $note->delete();
    //     return redirect()->route('notes.index')->with('success', 'Note deleted successfully.');
    // }

    // // Tambahkan di NoteController.php
    // public function togglePublic(Note $note)
    // {
    //     $this->authorize('update', $note); // Otorisasi
    //     $wasPublic = $note->is_public;
    //     $note->update(['is_public' => !$note->is_public]);

    //     // Jika berubah dari private/shared ke public, kirim notifikasi ke semua user (kecuali author) via job
    //     if (!$wasPublic && $note->fresh()->is_public) {
    //         foreach (User::where('id', '!=', $note->user_id)->get() as $user) {
    //             SendNotePublicNotification::dispatch($note, $note->user, $user);
    //         }
    //     }

    //     return back()->with('success', 'Status publik berhasil diubah.');
    // }

    // public function share(Request $request, Note $note)
    // {
    //     $this->authorize('update', $note); // Hanya pemilik yang bisa mengundang

    //     $validated = $request->validate([
    //         'email' => 'required|email|exists:users,email',
    //         'role' => 'required|string|in:viewer,editor'
    //     ]);

    //     $invitedUser = User::where('email', $validated['email'])->first();
    //     $inviter = auth()->user();

    //     // Jangan undang diri sendiri atau pengguna yang sudah diundang
    //     if ($invitedUser->id === $inviter->id || $note->sharedWithUsers->contains($invitedUser)) {
    //         return back()->with('error', 'Pengguna tidak valid atau sudah diundang.');
    //     }

    //     // Tambahkan relasi dengan peran
    //     $note->sharedWithUsers()->attach($invitedUser->id, ['role' => $validated['role']]);

    //     // Kirim job ke antrean! 🚀
    //     SendNoteInvitationEmail::dispatch($invitedUser, $note, $inviter, $validated['role']);

    //     return back()->with('success', $invitedUser->name . ' berhasil diundang sebagai ' . $validated['role']);
    // }
}

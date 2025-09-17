<?php

namespace App\Http\Controllers;

use App\Jobs\SendNoteInvitationEmail;
use App\Models\Note;
use App\Models\User;
use Illuminate\Http\Request;

class NoteController extends Controller
{
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
            default:
                $notes = $user->notes()->latest()->get();
                break;
        }

        return view('notes.index', compact('notes', 'filter'));
    }

    public function create()
    {
        return view('notes.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'content' => 'required|string',
        ]);

        $request->user()->notes()->create($validated);

        return redirect()->route('notes.index')->with('success', 'Catatan berhasil dibuat!');
    }

    public function show(Note $note)
    {
        // Otorisasi: hanya pemilik atau yang di-share boleh lihat
        abort_if(!$note->is_public && $note->user_id !== auth()->id() && !$note->sharedWithUsers->contains(auth()->id()), 403);
        return view('notes.show', compact('note'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Note $note)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Note $note)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Note $note)
    {
        $this->authorize('delete', $note);
        $note->delete();
        return redirect()->route('notes.index')->with('success', 'Note deleted successfully.');
    }

    // Tambahkan di NoteController.php
    public function togglePublic(Note $note)
    {
        $this->authorize('update', $note); // Otorisasi
        $note->update(['is_public' => !$note->is_public]);
        return back()->with('success', 'Status publik berhasil diubah.');
    }

    public function share(Request $request, Note $note)
    {
        $this->authorize('update', $note); // Hanya pemilik yang bisa mengundang

        $validated = $request->validate([
            'email' => 'required|email|exists:users,email',
            'role' => 'required|string|in:viewer,editor'
        ]);

        $invitedUser = User::where('email', $validated['email'])->first();
        $inviter = auth()->user();

        // Jangan undang diri sendiri atau pengguna yang sudah diundang
        if ($invitedUser->id === $inviter->id || $note->sharedWithUsers->contains($invitedUser)) {
            return back()->with('error', 'Pengguna tidak valid atau sudah diundang.');
        }

        // Tambahkan relasi dengan peran
        $note->sharedWithUsers()->attach($invitedUser->id, ['role' => $validated['role']]);

        // Kirim job ke antrean! 🚀
        SendNoteInvitationEmail::dispatch($invitedUser, $note, $inviter, $validated['role']);

        return back()->with('success', $invitedUser->name . ' berhasil diundang sebagai ' . $validated['role']);
    }
}

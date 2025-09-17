<?php

namespace App\Livewire;

use App\Models\Note;
use LivewireUI\Modal\ModalComponent;

class NoteForm extends ModalComponent
{
    public $noteId;
    public $title;
    public $content;

    public function mount($noteId = null)
    {
        if ($noteId) {
            $note = Note::findOrFail($noteId);
            $this->authorize('update', $note);
            $this->noteId = $note->id;
            $this->title = $note->title;
            $this->content = $note->content;
        }
    }

    public function save()
    {
        $this->validate([
            'title' => 'required|string|max:255',
            'content' => 'required|string',
        ]);

        if ($this->noteId) {
            // Update
            $note = Note::findOrFail($this->noteId);
            $this->authorize('update', $note);
            $note->update([
                'title' => $this->title,
                'content' => $this->content,
            ]);
        } else {
            // Create
            auth()->user()->notes()->create([
                'title' => $this->title,
                'content' => $this->content,
            ]);
        }

        $this->closeModal();
        $this->dispatch('noteSaved'); // Kirim event untuk refresh data
    }

    public function render()
    {
        return view('livewire.note-form');
    }
}

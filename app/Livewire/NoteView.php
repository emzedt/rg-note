<?php

namespace App\Livewire;

use App\Models\Note;
use LivewireUI\Modal\ModalComponent;

class NoteView extends ModalComponent
{
    public Note $note;

    public bool $showModal = false;

    public function mount($noteId)
    {
        $this->note = Note::findOrFail($noteId);
        $this->authorize('view', $this->note);
    }

    public function showDetail($id)
    {
        $this->detailNoteId = $id;
        $this->showDetail = true;
    }

    // Method untuk menutup detail note
    public function closeDetail()
    {
        $this->showDetail = false;
        $this->detailNoteId = null;
    }

    public function render()
    {
        return view('livewire.note-view');
    }
}

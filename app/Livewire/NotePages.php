<?php

namespace App\Livewire;

use App\Models\Note;
use Livewire\Component;

class NotePages extends Component // atau nama komponen Anda
{
    /**
     * Mendengarkan event dari komponen lain.
     * Jika event 'refreshNotesList' diterima, jalankan magic action '$refresh'.
     */
    protected $listeners = ['refreshNotesList' => '$refresh'];

    public function render()
    {
        return view('livewire.note-pages');
    }
}

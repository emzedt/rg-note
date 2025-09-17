<?php

namespace App\Livewire;

use App\Models\Note;
use Livewire\Component;
use Livewire\WithPagination;

class PublicNotes extends Component
{
    use WithPagination;
    
    public function render()
    {
        return view('livewire.public-notes', [
            'notes' => Note::where('is_public', true)
                ->with('owner')
                ->latest()
                ->paginate(10)
        ]);
    }
}
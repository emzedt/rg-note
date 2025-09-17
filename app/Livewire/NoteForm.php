<?php

namespace App\Livewire;

// Hapus `use LivewireUI\Modal\ModalComponent;`
use Livewire\Component; // Ganti menjadi ini
use App\Models\Note;
use Livewire\Attributes\Rule;

class NoteForm extends Component // Hapus `ModalComponent`
{
    // ... (properti $note, $title, $content, dan method mount() tetap sama)
    public ?Note $note;
    public $noteId;
    #[Rule('required|string|max:255')]
    public $title = '';
    #[Rule('required|string')]
    public $content = '';

    // public function mount($noteId = null)
    // {
    //     if ($noteId) {
    //         $this->note = Note::findOrFail($noteId);
    //         $this->authorize('update', $this->note);
    //         $this->noteId = $this->note->id;
    //         $this->title = $this->note->title;
    //         $this->content = $this->note->content;
    //     }
    // }

    public bool $showModal = false;


    public function save()
    {
        $this->validate();
        Note::create([
            'title' => $this->title,
            'content' => $this->content,
            'user_id' => auth()->id(),
        ]);
        $this->reset();
        $this->dispatchBrowserEvent('close-modal');
    }

    public function update(): void
    {
        $this->validate();

        $this->note->update($this->all());

        $this->reset();
    }

    public function render()
    {
        return view('livewire.note-form');
    }
}

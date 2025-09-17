<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Note;
use Livewire\Attributes\Rule;
use Livewire\WithFileUploads;
use LivewireUI\Modal\ModalComponent;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class NoteForm extends ModalComponent
{
    use WithFileUploads, AuthorizesRequests;

    public ?Note $note = null;
    public $noteId;
    public $isPublic = false;

    #[Rule('required|string|max:255')]
    public $title = '';

    #[Rule('required|string')]
    public $content = '';

    #[Rule('nullable|file|max:5120')]
    public $attachment;

    public bool $showModal = false;

    public function mount($noteId = null)
    {
        if ($noteId) {
            $this->note = Note::findOrFail($noteId);
            $this->authorize('update', $this->note);
            $this->noteId = $this->note->id;
            $this->title = $this->note->title;
            $this->content = $this->note->content;
            $this->isPublic = $this->note->is_public;
        }
    }

    public function save()
    {
        $this->validate();

        $data = [
            'title' => $this->title,
            'content' => $this->content,
            'user_id' => auth()->user()->id,
            'is_public' => $this->isPublic,
        ];

        if ($this->attachment) {
            $data['attachment_path'] = $this->attachment->store('attachments', 'public');
        }

        if ($this->noteId) {
            // Update existing note
            $note = Note::findOrFail($this->noteId);
            $this->authorize('update', $note);
            $note->update($data);
            session()->flash('message', 'Note updated successfully!');
        } else {
            // Create new note
            Note::create($data);
            session()->flash('message', 'Note created successfully!');
        }

        $this->reset(['title', 'content', 'attachment', 'isPublic']);
        $this->dispatch('closeModal');
        $this->dispatch('actionCompleted');
    }

    public function delete()
    {
        if ($this->noteId) {
            $note = Note::findOrFail($this->noteId);
            $this->authorize('delete', $note);
            $note->delete();
            session()->flash('message', 'Note deleted successfully!');
            return redirect()->route('notes.index');
        }
    }

    public function render()
    {
        return view('livewire.note-form');
    }
}

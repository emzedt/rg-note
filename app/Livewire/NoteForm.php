<?php

namespace App\Livewire;

use App\Jobs\SendNotePublicNotification;
use App\Models\Attachment;
use App\Models\Note;
use App\Models\User;
use Livewire\Attributes\Rule;
use LivewireUI\Modal\ModalComponent;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Support\Facades\Storage;
use Livewire\WithFileUploads; // <-- TAMBAHKAN INI

class NoteForm extends ModalComponent
{
    use AuthorizesRequests, WithFileUploads; // <-- TAMBAHKAN INI

    public ?Note $note = null;
    public $noteId;
    public $isPublic = false;

    #[Rule('required|string|max:50')]
    public $title = '';

    #[Rule('required|string|max:255')]
    public $content = '';

    // Untuk menampung file-file BARU yang di-upload sementara
    #[Rule([
        'newAttachments' => 'nullable|array',
        'newAttachments.*' => 'file|mimes:png,jpg,jpeg,pdf,doc,docx,ppt,pptx,zip|max:5120',
    ])]
    public $newAttachments = [];

    // Ganti nama variabel agar lebih jelas
    public $existingAttachments;

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
        $this->loadAttachments();
    }

    public function loadAttachments()
    {
        // Hanya muat attachment yang terikat pada note ini
        $this->existingAttachments = $this->note ? $this->note->attachments()->latest()->get() : collect();
    }

    public function save()
    {
        $this->validate();

        $wasPublic = $this->noteId ? $this->note->is_public : false;

        $data = [
            'title' => $this->title,
            'content' => $this->content,
            'is_public' => $this->isPublic,
        ];

        // Simpan atau update note terlebih dahulu
        if ($this->noteId) {
            // Jika note sudah ada (update), hanya perbarui data yang diizinkan
            $this->note->update($data);
            session()->flash('status', 'Note updated successfully!');
        } else {
            // Jika note baru (create), tambahkan user_id
            $data['user_id'] = auth()->id();
            $this->note = Note::create($data);
            $this->noteId = $this->note->id; // Ambil ID dari note yang baru dibuat
            session()->flash('status', 'Note created successfully!');
        }

        // Trigger email jika note baru public atau status berubah ke public
        if ((!$wasPublic && $this->isPublic) && $this->note) {
            foreach (User::where('id', '!=', $this->note->user_id)->get() as $user) {
                SendNotePublicNotification::dispatch($this->note, $this->note->user, $user);
            }
        }

        // Proses file-file baru yang diunggah sementara
        if (!empty($this->newAttachments)) {
            foreach ($this->newAttachments as $file) {
                $path = $file->store('attachments', 'public');
                Attachment::create([
                    'user_id'           => auth()->id(),
                    'note_id'           => $this->noteId, // Ikat ke note
                    'original_filename' => $file->getClientOriginalName(),
                    'path'              => $path,
                    'mime_type'         => $file->getMimeType(),
                    'size'              => $file->getSize(),
                ]);
            }
        }

        $this->dispatch('closeModal');
        $this->dispatch('actionCompleted');
    }

    // Menghapus attachment yang sudah ada di database
    public function deleteAttachment($attachmentId)
    {
        $attachment = Attachment::findOrFail($attachmentId);
        $this->authorize('delete', $attachment);
        Storage::disk('public')->delete($attachment->path);
        $attachment->delete();
        $this->loadAttachments(); // Muat ulang daftar
        session()->flash('status', 'Attachment deleted successfully!');
    }

    // Menghapus file dari daftar upload sementara (preview)
    public function removeNewAttachment($index)
    {
        array_splice($this->newAttachments, $index, 1);
    }

    public function render()
    {
        return view('livewire.note-form');
    }
}

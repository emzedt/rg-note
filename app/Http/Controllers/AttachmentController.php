<?php

namespace App\Http\Controllers;

use App\Models\Attachment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class AttachmentController extends Controller
{
    /**
     * Menerima file dari CKEditor, menyimpannya, dan membuat record di database.
     */
    public function store(Request $request)
    {
        // Validasi file yang diunggah
        $request->validate([
            'upload' => [
                'required',
                'file',
                'max:10240', // Maksimal 10MB
                // 'mimes:png,jpg,jpeg,pdf,ppt,pptx,doc,docx,zip' // Cara validasi lain
            ],
        ]);

        $file = $request->file('upload');

        // Simpan file ke storage dengan nama unik
        // Folder 'attachments' akan dibuat jika belum ada
        $path = $file->store('attachments', 'public');

        // Buat record di database
        $attachment = Attachment::create([
            'user_id'           => auth()->id(),
            'original_filename' => $file->getClientOriginalName(),
            'path'              => $path,
            'mime_type'         => $file->getMimeType(),
            'size'              => $file->getSize(),
        ]);

        // Kirim response JSON yang diharapkan CKEditor
        // URL-nya akan menunjuk ke method 'show' kita
        return response()->json([
            'url' => route('attachments.show', $attachment)
        ]);
    }

    /**
     * Menyajikan file untuk diunduh.
     */
    public function show(Attachment $attachment)
    {
        // Pastikan hanya user yang berhak yang bisa mengakses (opsional, tapi disarankan)
        // abort_if($attachment->user_id !== auth()->id(), 403);

        return Storage::disk('public')->download($attachment->path, $attachment->original_filename);
    }

    public function deleteAttachment($attachmentId)
    {
        $attachment = Attachment::findOrFail($attachmentId);
        $this->authorize('delete', $attachment); // <-- BIANG KELADINYA DI SINI
        // ...

        Storage::disk('public')->delete($attachment->path);
        $attachment->delete();

        return back()->with('status', 'Attachment deleted successfully!');
    }
}

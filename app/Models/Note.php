<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Facades\Storage;

class Note extends Model
{
    protected $fillable = ['title', 'content', 'user_id', 'is_public'];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function comments(): HasMany
    {
        return $this->hasMany(Comment::class)->latest();
    }

    public function sharedWithUsers(): BelongsToMany
    {
        return $this->belongsToMany(User::class, 'note_user')->withPivot('role') // <-- Bagian ini krusial
            ->withTimestamps();;
    }

    public function isEditor(User $user)
    {
        return $this->sharedWithUsers()->where('user_id', $user->id)->where('role', 'editor')->exists();
    }

    public function share(): HasMany
    {
        return $this->hasMany(NoteShare::class);
    }

    public function viewHistories(): HasMany
    {
        return $this->hasMany(NoteViewHistory::class);
    }

    public function attachments(): HasMany
    {
        return $this->hasMany(Attachment::class);
    }

    protected static function booted(): void
    {
        // Setiap kali sebuah note akan dihapus (event 'deleting')...
        static::deleting(function (Note $note) {
            // ...loop semua attachment yang terhubung...
            foreach ($note->attachments as $attachment) {
                // ...dan hapus file fisiknya dari storage.
                Storage::disk('public')->delete($attachment->path);
                // Record di database akan terhapus otomatis karena onDelete('cascade')
            }
        });
    }
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

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
        return $this->belongsToMany(User::class, 'note_user');
    }

    public function share(): HasMany
    {
        return $this->hasMany(NoteShare::class);
    }

    public function viewHistories(): HasMany
    {
        return $this->hasMany(NoteViewHistory::class);
    }
}

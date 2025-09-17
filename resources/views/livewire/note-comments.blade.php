<div class="mt-8 bg-gray-800 rounded-lg p-6 text-white">
    {{-- <h3 class="text-xl font-semibold mb-4">Comments</h3> --}}

    <div class="mb-6">
        <form wire:submit.prevent="addComment">
            <div class="flex flex-col space-y-2">
                <textarea wire:model="commentText" placeholder="Add a comment..."
                    class="w-full bg-gray-700 border-gray-600 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 text-white"
                    rows="3"></textarea>
                @error('commentText')
                    <span class="text-red-500 text-xs">{{ $message }}</span>
                @enderror
                <div class="flex justify-end">
                    <button type="submit" class="px-4 py-2 bg-indigo-600 text-white rounded-md hover:bg-indigo-500">
                        Add Comment
                    </button>
                </div>
            </div>
        </form>
    </div>

    <div class="space-y-4">
        @forelse($comments as $comment)
            <div class="bg-gray-700 rounded-lg p-4">
                <div class="flex justify-between items-start">
                    <div>
                        <div class="font-medium">{{ $comment->user->name }}</div>
                        <div class="text-xs text-gray-400">{{ $comment->created_at->diffForHumans() }}</div>
                    </div>
                    @if (auth()->id() === $comment->user_id || auth()->id() === $note->user_id)
                        <button wire:click="deleteComment({{ $comment->id }})" class="text-gray-400 hover:text-red-400"
                            onclick="return confirm('Are you sure you want to delete this comment?')">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24"
                                stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                            </svg>
                        </button>
                    @endif
                </div>
                <div class="mt-2 text-gray-200">
                    {{ $comment->body }}
                </div>
            </div>
        @empty
            <div class="text-center text-gray-400 py-4">
                No comments yet. Be the first to comment!
            </div>
        @endforelse
    </div>
</div>

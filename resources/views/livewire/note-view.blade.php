<div class="p-8 bg-gray-800 rounded-lg text-white max-w-3xl mx-auto">
    <div class="flex justify-between items-start mb-4">
        <h1 class="text-3xl font-bold text-white">{{ $note->title }}</h1>
        
        <div class="flex space-x-2">
            @if(auth()->id() === $note->user_id)
                <button wire:click="toggleInviteForm" class="px-3 py-1 bg-blue-600 text-white rounded-md hover:bg-blue-500 text-sm">
                    Invite User
                </button>
                <a href="{{ route('notes.edit', $note->id) }}" class="px-3 py-1 bg-indigo-600 text-white rounded-md hover:bg-indigo-500 text-sm">
                    Edit
                </a>
            @endif
            <button wire:click="$dispatch('closeModal')" class="px-3 py-1 bg-gray-600 text-white rounded-md hover:bg-gray-500 text-sm">
                Close
            </button>
        </div>
    </div>
    
    <!-- Invite User Form -->
    @if($showInviteForm && auth()->id() === $note->user_id)
        <div class="mb-6 p-4 bg-gray-700 rounded-lg">
            <h3 class="text-lg font-medium mb-3">Invite User</h3>
            <form wire:submit.prevent="inviteUser" class="space-y-4">
                <div>
                    <label for="selectedUserId" class="block text-sm font-medium text-gray-300 mb-1">Select User</label>
                    <select wire:model="selectedUserId" id="selectedUserId" class="w-full bg-gray-800 border border-gray-600 rounded-md px-3 py-2 text-white focus:outline-none focus:ring-2 focus:ring-indigo-500">
                        <option value="">-- Select a user --</option>
                        @foreach($users as $user)
                            <option value="{{ $user->id }}">{{ $user->name }} ({{ $user->email }})</option>
                        @endforeach
                    </select>
                    @error('selectedUserId') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                </div>
                <div class="flex justify-end space-x-2">
                    <button type="button" wire:click="toggleInviteForm" class="px-3 py-1 bg-gray-600 text-white rounded-md hover:bg-gray-500 text-sm">
                        Cancel
                    </button>
                    <button type="submit" class="px-3 py-1 bg-green-600 text-white rounded-md hover:bg-green-500 text-sm">
                        Invite
                    </button>
                </div>
            </form>
        </div>
    @endif
    
    <div class="flex items-center mb-6 text-gray-400 text-sm">
        <div class="flex items-center">
            <span class="font-medium text-gray-300">{{ $note->owner->name }}</span>
            <span class="mx-2">•</span>
            <span>Created {{ $note->created_at->format('M d, Y') }}</span>
        </div>
        @if($note->created_at->ne($note->updated_at))
            <span class="mx-2">•</span>
            <span>Updated {{ $note->updated_at->format('M d, Y') }}</span>
        @endif
        
        @if($note->is_public)
            <span class="mx-2">•</span>
            <span class="bg-green-900 text-green-300 px-2 py-0.5 rounded-full text-xs">Public</span>
        @endif
    </div>

    <div class="prose prose-invert max-w-none mb-6">
        {!! $note->content !!}
    </div>
    
    @livewire('note-comments', ['note' => $note])
</div>

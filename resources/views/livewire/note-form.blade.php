<div>
    <form wire:submit="save" class="p-6 bg-gray-800 rounded-lg text-white">
        <h2 class="text-2xl font-bold mb-4">{{ $noteId ? 'Edit Note' : 'Create Note' }}</h2>
        {{-- Title --}}
        <div class="mb-4">
            <label for="title" class="block text-sm font-medium text-gray-300">Title</label>
            <input type="text" wire:model="title" id="title"
                class="mt-1 block w-full bg-gray-700 border-gray-600 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 text-white">
            @error('title')
                <span class="text-red-500 text-xs">{{ $message }}</span>
            @enderror
        </div>
        {{-- Content --}}
        <div class="mb-4">
            <label for="content" class="block text-sm font-medium text-gray-300">Content</label>
            <textarea wire:model="content" id="content" rows="10"
                class="mt-1 block w-full bg-gray-700 border-gray-600 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 text-white"></textarea>
            @error('content')
                <span class="text-red-500 text-xs">{{ $message }}</span>
            @enderror
        </div>
        {{-- Buttons --}}
        <div class="flex justify-end space-x-2">
            <button type="button" class="px-4 py-2 bg-gray-600 text-gray-200 rounded-md hover:bg-gray-500"
                x-on:click="$dispatch('close-modal')">Cancel</button>
            <button type="submit" class="px-4 py-2 bg-indigo-600 text-white rounded-md hover:bg-indigo-500">Save
                Note</button>
        </div>
    </form>
</div>

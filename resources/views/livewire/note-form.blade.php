<div>
    <form wire:submit.prevent="save" class="p-6">
        <h2 class="text-2xl font-bold mb-4">{{ $noteId ? 'Edit Note' : 'Create Note' }}</h2>
        <div class="mb-4">
            <label for="title" class="block text-sm font-medium text-gray-700">Title</label>
            <input type="text" wire:model.defer="title" id="title"
                class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500">
            @error('title')
                <span class="text-red-500 text-xs">{{ $message }}</span>
            @enderror
        </div>
        <div class="mb-4">
            <label for="content" class="block text-sm font-medium text-gray-700">Content</label>
            <textarea wire:model.defer="content" id="content" rows="10"
                class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500"></textarea>
            @error('content')
                <span class="text-red-500 text-xs">{{ $message }}</span>
            @enderror
        </div>
        <div class="flex justify-end space-x-2">
            <button type="button" class="px-4 py-2 bg-gray-200 text-gray-800 rounded-md hover:bg-gray-300"
                wire:click="$dispatch('closeModal')">Cancel</button>
            <button type="submit" class="px-4 py-2 bg-indigo-600 text-white rounded-md hover:bg-indigo-700">Save
                Note</button>
        </div>
    </form>
</div>

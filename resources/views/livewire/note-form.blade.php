<div class="relative p-6 bg-gray-800 rounded-lg text-white w-full max-w-7xl mx-auto">
    <button type="button" wire:click="$dispatch('closeModal')"
        class="absolute top-0 right-0 mt-4 mr-4 text-gray-400 hover:text-white transition">
        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
        </svg>
    </button>
    <form wire:submit="save" enctype="multipart/form-data">
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

        {{-- Content dengan CKEditor --}}
        <div class="mb-4" wire:ignore x-data x-init="ClassicEditor
            .create(document.querySelector('#content'))
            .then(editor => {
                // Set data awal jika sedang mode edit
                editor.setData(@this.get('content') || '');
        
                // Dengarkan perubahan pada editor
                editor.model.document.on('change:data', () => {
                    // Kirim data terbaru ke Livewire
                    @this.set('content', editor.getData());
                });
            })
            .catch(error => {
                console.error(error);
            });">
            <label for="content" class="block text-sm font-medium text-gray-300">Content</label>
            <textarea wire:model="content" id="content" rows="20"
                class="mt-1 block w-full bg-gray-700 border-gray-600 rounded-md shadow-sm"></textarea>
        </div>
        @error('content')
            <span class="text-red-500 text-xs -mt-3 mb-3 block">{{ $message }}</span>
        @enderror
        {{-- Public Option --}}
        <div class="mb-4 flex items-center">
            <input type="checkbox" wire:model="isPublic" id="isPublic"
                class="mr-2 bg-gray-700 border-gray-600 rounded">
            <label for="isPublic" class="text-sm font-medium text-gray-300">Make this note public</label>
        </div>
        {{-- Buttons --}}
        <div class="flex justify-between">
            @if ($noteId)
                <button type="button" wire:click="delete"
                    onclick="return confirm('Are you sure you want to delete this note?')"
                    class="px-4 py-2 bg-red-600 text-white rounded-md hover:bg-red-500">
                    Delete Note
                </button>
            @else
                <div></div>
            @endif
            <div class="flex space-x-2">
                <button type="button" wire:click="$dispatch('closeModal')"
                    class="px-4 py-2 bg-gray-600 text-gray-200 rounded-md hover:bg-gray-500">
                    Cancel
                </button>
                <button type="submit" class="px-4 py-2 bg-indigo-600 text-white rounded-md hover:bg-indigo-500">
                    {{ $noteId ? 'Update' : 'Save' }} Note
                </button>
            </div>
        </div>
    </form>
    <script>
        document.addEventListener('livewire:navigated', () => {
            if (window.ClassicEditor && document.getElementById('content')) {
                ClassicEditor.create(document.getElementById('content'));
            }
        });
    </script>
    <script src="https://cdn.ckeditor.com/ckeditor5/41.4.2/classic/ckeditor.js"></script>
</div>

<div class="relative p-6 bg-gray-800 rounded-lg text-white w-full max-w-4xl mx-auto">
    {{-- Close Button --}}
    <button type="button" wire:click="$dispatch('closeModal')"
        class="absolute top-2 right-0 mt-4 mr-4 text-gray-400 hover:text-white transition">
        <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
        </svg>
    </button>

    <form wire:submit="save">
        <h2 class="text-2xl font-bold mb-4">{{ $noteId ? 'Edit Note' : 'Create Note' }}</h2>

        {{-- Title --}}
        <div class="mb-4">
            <label for="title" class="block text-sm font-medium text-gray-300">Title</label>
            <input type="text" wire:model="title" id="title"
                class="mt-1 block w-full bg-gray-700 border-gray-600 rounded-md shadow-sm">
            @error('title')
                <span class="text-red-500 text-xs">{{ $message }}</span>
            @enderror
        </div>

        {{-- CKEditor Content --}}
        <div class="mb-4" wire:ignore x-data x-init="ClassicEditor
            .create(document.querySelector('#content_editor'))
            .then(editor => {
                editor.setData(@this.get('content') || '');
                editor.model.document.on('change:data', () => {
                    @this.set('content', editor.getData());
                });
            })
            .catch(error => { console.error(error); });">
            <label for="content_editor" class="block text-sm font-medium text-gray-300">Content</label>
            <textarea id="content_editor" rows="12" class="mt-1 block w-full bg-gray-700 border-gray-600 rounded-md shadow-sm"></textarea>
        </div>
        @error('content')
            <span class="text-red-500 text-xs">{{ $message }}</span>
        @enderror

        {{-- Public Option --}}
        <div class="mb-4 flex items-center">
            <input type="checkbox" wire:model="isPublic" id="isPublic"
                class="mr-2 bg-gray-700 border-gray-600 rounded">
            <label for="isPublic" class="text-sm font-medium text-gray-300">Make this note public</label>
        </div>

        {{-- File Upload & Manager Section --}}
        <div class="mt-6 border-t border-gray-700 pt-4" x-data="{ isDropping: false }" @dragover.prevent="isDropping = true"
            @dragleave.prevent="isDropping = false"
            @drop.prevent="isDropping = false; $wire.uploadMultiple('newAttachments', $event.dataTransfer.files)">

            <h3 class="text-lg font-semibold text-gray-200 mb-2">Attachments</h3>

            {{-- Dropzone --}}
            <label for="file-upload" :class="isDropping ? 'border-indigo-400 bg-gray-900/80' : 'border-gray-600'"
                class="relative block w-full border-2 border-dashed rounded-lg p-8 text-center cursor-pointer hover:border-indigo-500 transition-colors">
                <input id="file-upload" type="file" wire:model="newAttachments" multiple class="sr-only">
                <span class="text-gray-400">Drag & drop files here, or click to select files</span>
                <span class="text-gray-400">MAX 5 MB per files</span>
                <br>
                <span class="text-gray-400">(.png, .jpg, .jpeg, .pdf, .doc, .docx, <br> .ppt, .pptx, .zip)</span>
            </label>
            @error('newAttachments.*')
                <span class="text-red-500 text-xs mt-1">{{ $message }}</span>
            @enderror

            {{-- Upload Progress Indicator --}}
            <div wire:loading.flex wire:target="newAttachments" class="items-center w-full mt-4 text-sm text-gray-400">
                <svg class="animate-spin -ml-1 mr-3 h-5 w-5" xmlns="http://www.w3.org/2000/svg" fill="none"
                    viewBox="0 0 24 24">
                    <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor"
                        stroke-width="4"></circle>
                    <path class="opacity-75" fill="currentColor"
                        d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z">
                    </path>
                </svg>
                <span>Uploading...</span>
            </div>

            {{-- Grid for file previews --}}
            <div class="mt-4 grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-4">
                {{-- Temporary New File Previews --}}
                @foreach ($newAttachments as $index => $file)
                    <div class="relative group p-2 bg-gray-700 rounded-md flex items-center space-x-3">
                        @if (Str::startsWith($file->getMimeType(), 'image/'))
                            <img src="{{ $file->temporaryUrl() }}" class="w-12 h-12 rounded-md object-cover">
                        @else
                            <div class="w-12 h-12 rounded-md bg-gray-600 flex items-center justify-center">
                                <svg class="w-8 h-8 text-gray-400" fill="none" stroke="currentColor"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M7 21h10a2 2 0 002-2V9.414a1 1 0 00-.293-.707l-5.414-5.414A1 1 0 0012.586 3H7a2 2 0 00-2 2v14a2 2 0 002 2z">
                                    </path>
                                </svg>
                            </div>
                        @endif
                        <div class="flex-1 min-w-0">
                            <p class="text-sm text-gray-300 truncate">{{ $file->getClientOriginalName() }}</p>
                        </div>
                        <button type="button" wire:click="removeNewAttachment({{ $index }})"
                            class="absolute -top-2 -right-2 text-gray-400 bg-gray-800 rounded-full hover:text-white opacity-0 group-hover:opacity-100 transition-opacity">
                            <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd"
                                    d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z"
                                    clip-rule="evenodd"></path>
                            </svg>
                        </button>
                    </div>
                @endforeach

                {{-- Existing Saved Files --}}
                {{-- Daftar File Lama (Existing) --}}
                @foreach ($existingAttachments as $attachment)
                    <div class="relative group p-2 bg-gray-700/50 rounded-md flex items-center space-x-3">
                        {{-- Ikon atau Preview Gambar --}}
                        @if (Str::startsWith($attachment->mime_type, 'image/'))
                            <a href="{{ Storage::url($attachment->path) }}" target="_blank" class="flex-shrink-0">
                                <img src="{{ Storage::url($attachment->path) }}"
                                    class="w-12 h-12 rounded-md object-cover">
                            </a>
                        @else
                            <a href="{{ route('attachments.show', $attachment) }}" target="_blank"
                                class="flex-shrink-0 w-12 h-12 rounded-md bg-gray-600 flex items-center justify-center">
                                <svg class="w-8 h-8 text-gray-400" fill="none" stroke="currentColor"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M7 21h10a2 2 0 002-2V9.414a1 1 0 00-.293-.707l-5.414-5.414A1 1 0 0012.586 3H7a2 2 0 00-2 2v14a2 2 0 002 2z">
                                    </path>
                                </svg>
                            </a>
                        @endif
                        {{-- Bagian Nama File (Dengan Perbaikan) --}}
                        <div class="flex-1 min-w-0">
                            <a href="{{ route('attachments.show', $attachment) }}" target="_blank"
                                class="text-sm text-indigo-400 hover:underline block truncate">
                                {{ $attachment->original_filename }}
                            </a>
                        </div>
                        {{-- Tombol Delete --}}
                        <button type="button" wire:click="deleteAttachment({{ $attachment->id }})"
                            wire:confirm="Are you sure?"
                            class="absolute -top-2 -right-2 text-red-600 bg-gray-800 rounded-full hover:text-red-400 opacity-0 group-hover:opacity-100 transition-opacity">
                            <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd"
                                    d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z"
                                    clip-rule="evenodd"></path>
                            </svg>
                        </button>
                    </div>
                @endforeach
            </div>
        </div>

        {{-- Buttons --}}
        <div class="flex space-x-2 justify-end mt-6">
            <button type="button" wire:click="$dispatch('closeModal')"
                class="px-4 py-2 bg-gray-600 rounded-md hover:bg-gray-500">Cancel</button>
            <button type="submit"
                class="px-4 py-2 bg-indigo-600 text-white rounded-md hover:bg-indigo-500">{{ $noteId ? 'Update' : 'Save' }}
                Note</button>
        </div>
    </form>

    <script src="https://cdn.ckeditor.com/ckeditor5/41.4.2/classic/ckeditor.js"></script>
</div>

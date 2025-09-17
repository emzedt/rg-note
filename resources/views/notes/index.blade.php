<x-app-layout>
    <div class="p-8">
        <header class="flex justify-between items-center mb-8">
            <div class="flex items-center space-x-4">
                <button @click="sidebarOpen = !sidebarOpen" class="text-gray-400 hover:text-white">
                    <svg class="w-6 h-6" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                        stroke-width="1.5" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="M3.75 6.75h16.5M3.75 12h16.5m-16.5 5.25h16.5" />
                    </svg>
                </button>
                <h1 class="text-3xl font-bold text-white">
                    {{ ucfirst($filter) }} Notes
                </h1>
            </div>
            <button type="button" onclick="Livewire.dispatch('openModal', { component: 'note-form' })"
                class="inline-flex items-center px-4 py-2 bg-indigo-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-indigo-500 active:bg-indigo-700">
                <svg class="w-4 h-4 mr-2" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                    stroke-width="2" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15" />
                </svg>
                Create Note
            </button>
        </header>

        @if ($notes->count())
            <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6">
                @foreach ($notes as $note)
                    <div
                        class="bg-gray-800 rounded-lg border border-gray-700 overflow-hidden group hover:border-indigo-500 transition-all duration-300">
                        <div class="p-5 cursor-pointer"
                            onclick="Livewire.dispatch('openModal', { component: 'note-view', arguments: { noteId: {{ $note->id }} } })">
                            <h3 class="text-lg font-semibold text-gray-200 truncate">{{ $note->title }}</h3>
                            <div class="mt-2 text-sm text-gray-400 line-clamp-4">
                                {{ strip_tags($note->content) }}
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        @else
            <div class="text-center py-20">
                <p class="text-gray-500">No notes found in this section.</p>
            </div>
        @endif
    </div>
</x-app-layout>

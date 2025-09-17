<x-app-layout>
    <div class="p-8">
        <header class="flex justify-between items-center mb-8" x-data>
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
        </header>

        <div class="p-4 mb-8 flex justify-end">
            <button type="button" onclick="Livewire.dispatch('openModal', { component: 'note-form' })"
                class="inline-flex items-center px-4 py-2 bg-indigo-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-indigo-500 active:bg-indigo-700">
                <svg class="w-4 h-4 mr-2" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                    stroke-width="2" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15" />
                </svg>
                Create Note
            </button>
        </div>

        @if ($notes->count())
            <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6">
                @foreach ($notes as $note)
                    <div
                        class="bg-gray-800 rounded-lg border border-gray-700 overflow-hidden group hover:border-indigo-500 hover:shadow-lg hover:shadow-indigo-500/20 transition-all duration-300">
                        <a href="{{ route('notes.show', $note) }}" class="block w-full text-left p-5 cursor-pointer">
                            <h3 class="text-lg font-semibold text-gray-200 truncate">{{ $note->title }}</h3>
                            <div class="mt-2 text-sm text-gray-400 line-clamp-3 prose prose-sm prose-invert max-w-none">
                                {{ strip_tags($note->content) }}
                            </div>
                            <div class="mt-4 flex justify-between items-center text-xs">
                                <div class="flex flex-col h-full">
                                    <div class="flex items-center text-sm text-gray-400">
                                        <img class="h-5 w-5 rounded-full mr-2"
                                            src="https://ui-avatars.com/api/?name={{ urlencode($note->user->name) }}&background=4f46e5&color=fff"
                                            alt="Avatar">
                                        <span class="mr-1">By {{ $note->user->name }}</span>
                                        <span class="mx-1">•</span>
                                        <span>{{ $note->updated_at->diffForHumans() }}</span>
                                    </div>
                                </div>
                                <div class="flex space-x-2">
                                    @if ($note->sharedWithUsers->count() > 0)
                                        <span class="px-2 py-1 bg-blue-900 text-blue-300 rounded-full">Shared</span>
                                    @endif
                                    @if ($note->is_public)
                                        <span class="px-2 py-1 bg-green-900 text-green-300 rounded-full">Public</span>
                                    @endif
                                </div>
                            </div>
                        </a>
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

<x-app-layout>
    <div class="bg-gray-50 min-h-screen">
        <header class="bg-white border-b border-gray-200">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="flex justify-between items-center h-16">
                    <h1 class="text-2xl font-bold text-gray-800">My Notes</h1>
                    <button onclick="Livewire.dispatch('openModal', { component: 'note-form' })"
                        class="inline-flex items-center px-4 py-2 bg-indigo-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-indigo-700 active:bg-indigo-900 focus:outline-none focus:border-indigo-900 focus:ring ring-indigo-300 disabled:opacity-25 transition ease-in-out duration-150">
                        Create New Note
                    </button>
                </div>
            </div>
        </header>

        <main class="py-10">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6">

                    @foreach ($notes as $note)
                        <div class="bg-white rounded-lg shadow-sm border border-gray-200 overflow-hidden group">
                            <div class="p-5">
                                <h3 class="text-lg font-semibold text-gray-900 truncate">{{ $note->title }}</h3>
                                <div class="mt-2 text-sm text-gray-600 line-clamp-4">
                                    {!! strip_tags($note->content) !!}
                                </div>
                            </div>
                            <div
                                class="px-5 py-3 bg-gray-50 border-t border-gray-200 flex justify-end items-center space-x-2 opacity-0 group-hover:opacity-100 transition-opacity duration-300">
                                <button
                                    onclick="Livewire.dispatch('openModal', { component: 'note-form', arguments: { noteId: {{ $note->id }} } })"
                                    class="text-gray-500 hover:text-indigo-600 focus:outline-none">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                                        xmlns="http://www.w3.org/2000/svg">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.5L16.732 3.732z">
                                        </path>
                                    </svg>
                                </button>
                                <button
                                    onclick="Livewire.dispatch('openModal', { component: 'note-view', arguments: { noteId: {{ $note->id }} } })"
                                    class="text-gray-500 hover:text-blue-600 focus:outline-none">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                                        xmlns="http://www.w3.org/2000/svg">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z">
                                        </path>
                                    </svg>
                                </button>
                            </div>
                        </div>
                    @endforeach

                </div>
            </div>
        </main>
    </div>
</x-app-layout>

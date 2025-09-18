<x-app-layout>
    <div class="p-8 text-white">
        {{-- <header class="mb-10">
            <h1 class="text-3xl font-bold">{{ $greeting }}</h1>
        </header> --}}

        <header class="flex justify-between items-center mb-8" x-data>
            <div class="flex items-center space-x-4">
                <button @click="sidebarOpen = !sidebarOpen" class="text-gray-400 hover:text-white">
                    <svg class="w-6 h-6" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                        stroke-width="1.5" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="M3.75 6.75h16.5M3.75 12h16.5m-16.5 5.25h16.5" />
                    </svg>
                </button>
            </div>
        </header>

        <div class="py-24 flex items-center justify-center">
            <h1
                class="text-4xl font-bold bg-gradient-to-r from-indigo-500 via-purple-500 to-pink-500 bg-clip-text text-transparent bg-300% animate-gradient-move">
                {{ $greeting }}
            </h1>
        </div>


        <div class="mb-12">

            <button type="button" onclick="Livewire.dispatch('openModal', { component: 'note-form' })"
                class="flex flex-col items-center justify-center bg-gray-800 hover:bg-gray-700 rounded-lg p-4 h-32 w-100 text-center transition-colors duration-200 mb-5">
                <div class="flex items-center justify-center w-12 h-12 bg-gray-700 rounded-lg mb-2">
                    <svg class="w-6 h-6" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                        stroke-width="1.5" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15" />
                    </svg>
                </div>
                <span class="font-medium">New note</span>
            </button>

            <h2 class="text-sm font-medium text-gray-400 mb-4 flex items-center">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 inline-block mr-2" viewBox="0 0 20 20"
                    fill="currentColor">
                    <path fill-rule="evenodd"
                        d="M10 18a8 8 0 100-16 8 8 0 000 16zm1-12a1 1 0 10-2 0v4a1 1 0 00.293.707l2.828 2.829a1 1 0 101.414-1.414L11 10.586V6z"
                        clip-rule="evenodd" />
                </svg>
                Recently visited
            </h2>

            <div class="grid grid-cols-1 md:grid-cols-3 lg:grid-cols-5 gap-4">
                @foreach ($histories as $history)
                    @php $note = $history->note; @endphp
                    <a href="{{ route('notes.show', $note) }}"
                        class="block bg-gray-800 hover:bg-gray-700 rounded-lg p-4 h-32 transition-colors duration-200">
                        <div class="flex flex-col h-full">
                            <p class="flex-grow font-semibold truncate">{{ $note->title }}</p>
                            <div class="text-sm text-gray-400">
                                <div class="flex items-center">
                                    <img class="h-5 w-5 rounded-full mr-2"
                                        src="https://ui-avatars.com/api/?name={{ urlencode($note->user->name) }}&background=4f46e5&color=fff"
                                        alt="Avatar">
                                    <span>By {{ $note->user->name }}</span>
                                </div>
                                <span class="block mt-1">Last visit {{ $history->updated_at->diffForHumans() }}</span>
                            </div>
                        </div>
                    </a>
                @endforeach
            </div>
        </div>
    </div>
</x-app-layout>

<x-app-layout>
    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-100">
                    <div class="flex justify-between items-start mb-6">
                        <h1 class="text-2xl font-bold text-white">{{ $note->title }}</h1>
                        <div class="flex space-x-2">
                            @if (auth()->id() === $note->user_id)
                                {{-- <a href="{{ route('notes.edit', $note->id) }}" class="px-4 py-2 bg-blue-600 rounded-md text-white text-sm">Edit</a> --}}
                                <form action="{{ route('notes.destroy', $note->id) }}" method="POST" class="inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="px-4 py-2 bg-red-600 rounded-md text-white"
                                        onclick="return confirm('Are you sure?')">Delete</button>
                                </form>
                            @endif
                        </div>
                    </div>

                    <div class="mb-4 text-sm text-gray-400">
                        <div class="flex items-center space-x-2">
                            <span>By: {{ $note->user->name }}</span>
                            <span>•</span>
                            <span>Created: {{ $note->created_at->format('M d, Y H:i') }}</span>
                            @if ($note->created_at != $note->updated_at)
                                <span>•</span>
                                <span>Updated: {{ $note->updated_at->format('M d, Y H:i') }}</span>
                            @endif
                            @if ($note->is_public)
                                <span>•</span>
                                <span class="px-2 py-1 bg-green-900 text-green-300 rounded-full text-xs">Public</span>
                            @endif
                        </div>
                    </div>

                    <div class="prose prose-invert max-w-none mt-6">
                        {!! $note->content !!}
                    </div>

                    @if (auth()->id() === $note->user_id)
                        <div class="mt-8 border-t border-gray-700 pt-6">
                            <div x-data="{ open: false }">
                                <div @click="open = !open"
                                    class="flex justify-between items-center cursor-pointer group">
                                    <h3 class="text-lg font-semibold text-gray-200">
                                        Share This Note
                                    </h3>
                                    <svg class="w-5 h-5 text-gray-400 transform transition-transform duration-300"
                                        :class="{ 'rotate-180': open }" xmlns="http://www.w3.org/2000/svg"
                                        viewBox="0 0 20 20" fill="currentColor">
                                        <path fill-rule="evenodd"
                                            d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z"
                                            clip-rule="evenodd" />
                                    </svg>
                                </div>
                                <div x-show="open" x-transition class="mt-4">
                                    @livewire('share-note', ['note' => $note])
                                </div>
                            </div>
                        </div>
                    @endif

                    <div class="mt-8 border-t border-gray-700 pt-6">
                        <h3 class="text-lg font-semibold mb-4">Comments</h3>
                        @livewire('note-comments', ['note' => $note])
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>

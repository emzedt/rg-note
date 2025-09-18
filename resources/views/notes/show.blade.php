<x-app-layout>
    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-100">
                    <div class="flex justify-between items-start mb-6">
                        <h1 class="text-2xl font-bold text-white">{{ $note->title }}</h1>
                        <div class="flex space-x-2">
                            @if (auth()->id() === $note->user_id)
                                <button type="button"
                                    onclick="Livewire.dispatch('openModal', { component: 'note-form', arguments: { noteId: {{ $note->id }} } })"
                                    class="px-4 py-2 bg-blue-600 rounded-md text-white text-sm hover:bg-blue-500">
                                    Edit
                                </button>
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

                    {{-- =================== BAGIAN ATTACHMENTS =================== --}}
                    @if ($note->attachments->isNotEmpty())
                        <div class="mt-8 border-t border-gray-700 pt-6">
                            <h3 class="text-lg font-semibold text-gray-200 mb-4">Attachments</h3>
                            <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-4">
                                @foreach ($note->attachments as $attachment)
                                    <a href="{{ route('attachments.show', $attachment) }}" target="_blank"
                                        class="relative group p-3 bg-gray-700/50 rounded-md flex items-center space-x-4 hover:bg-gray-700 transition-colors">

                                        {{-- Preview or Icon --}}
                                        @if (Str::startsWith($attachment->mime_type, 'image/'))
                                            {{-- Image Preview --}}
                                            <div class="flex-shrink-0">
                                                <img src="{{ Storage::url($attachment->path) }}"
                                                    alt="{{ $attachment->original_filename }}"
                                                    class="w-12 h-12 rounded-md object-cover">
                                            </div>
                                        @else
                                            {{-- Generic File Icon --}}
                                            <div
                                                class="flex-shrink-0 w-12 h-12 rounded-md bg-gray-600 flex items-center justify-center">
                                                <svg class="w-8 h-8 text-gray-400" fill="none" stroke="currentColor"
                                                    viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round"
                                                        stroke-width="2"
                                                        d="M7 21h10a2 2 0 002-2V9.414a1 1 0 00-.293-.707l-5.414-5.414A1 1 0 0012.586 3H7a2 2 0 00-2 2v14a2 2 0 002 2z">
                                                    </path>
                                                </svg>
                                            </div>
                                        @endif

                                        {{-- File Info --}}
                                        <div class="flex-1 min-w-0">
                                            <p
                                                class="text-sm font-medium text-indigo-400 truncate group-hover:underline">
                                                {{ $attachment->original_filename }}</p>
                                            <p class="text-xs text-gray-500">{{ $attachment->formatted_size }}</p>
                                        </div>
                                    </a>
                                @endforeach
                            </div>
                        </div>
                    @endif
                    {{-- ================= END BAGIAN ATTACHMENTS ================= --}}

                    <div class="mt-6 flex justify-end">
                        <a href="{{ url()->previous() }}"
                            class="px-4 py-2 bg-gray-600 text-gray-200 rounded-md hover:bg-gray-500">
                            Back to Note
                        </a>
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
    <script>
        // Jalankan script setelah semua konten halaman dimuat
        document.addEventListener('DOMContentLoaded', function() {
            // Cari semua elemen <oembed> yang ada di dalam konten
            document.querySelectorAll('oembed[url]').forEach(element => {
                // Hanya proses URL dari youtube.com
                if (element.getAttribute('url').includes('youtube.com')) {
                    const url = new URL(element.getAttribute('url'));
                    const videoId = url.searchParams.get('v');

                    if (videoId) {
                        // Buat div pembungkus untuk video responsif (aspek rasio 16:9)
                        const wrapper = document.createElement('div');
                        wrapper.style.position = 'relative';
                        wrapper.style.paddingBottom = '56.25%'; // 16:9
                        wrapper.style.height = '0';
                        wrapper.style.overflow = 'hidden';
                        wrapper.style.maxWidth = '100%';
                        wrapper.style.margin = '20px 0'; // Beri sedikit spasi

                        // Buat elemen <iframe>
                        const iframe = document.createElement('iframe');
                        iframe.setAttribute('src', `https://www.youtube.com/embed/${videoId}`);
                        iframe.setAttribute('frameborder', '0');
                        iframe.setAttribute('allow',
                            'accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture'
                        );
                        iframe.setAttribute('allowfullscreen', '');
                        iframe.style.position = 'absolute';
                        iframe.style.top = '0';
                        iframe.style.left = '0';
                        iframe.style.width = '100%';
                        iframe.style.height = '100%';

                        // Masukkan iframe ke dalam wrapper
                        wrapper.appendChild(iframe);

                        // Ganti elemen <figure> yang berisi <oembed> dengan wrapper video
                        const figure = element.closest('figure.media');
                        if (figure) {
                            figure.parentNode.replaceChild(wrapper, figure);
                        }
                    }
                }
            });
        });
    </script>
</x-app-layout>

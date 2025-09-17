<x-app-layout>
    {{-- <div class="prose max-w-none">
        {!! $note->content !!}
    </div>
    <form method="POST" action="{{ route('notes.share', $note) }}">
        @csrf
        <div class="flex items-center space-x-2">
            <x-text-input type="email" name="email" placeholder="Email pengguna..." required />
            <select name="role" class="border-gray-300 rounded-md shadow-sm">
                <option value="viewer">Viewer</option>
                <option value="editor">Editor</option>
            </select>
            <x-primary-button>Undang</x-primary-button>
        </div>
        <x-input-error :messages="$errors->get('email')" class="mt-2" />
    </form> --}}

    <div class="w-80 border-l border-gray-200 p-4 flex flex-col h-full">
        <h3 class="text-lg font-semibold mb-4">Comments</h3>

        <div class="flex-1 overflow-y-auto space-y-4">
            @foreach ($note->comments as $comment)
                <div class="flex items-start space-x-3">
                    <img class="h-8 w-8 rounded-full"
                        src="https://ui-avatars.com/api/?name={{ urlencode($comment->user->name) }}" alt="">
                    <div class="flex-1">
                        <p class="text-sm">
                            <span class="font-semibold text-gray-900">{{ $comment->user->name }}</span>
                            <span class="text-gray-500">{{ $comment->created_at->diffForHumans() }}</span>
                        </p>
                        <p class="mt-1 text-sm text-gray-700">{!! nl2br(e($comment->body)) !!}</p>
                    </div>
                </div>
            @endforeach
        </div>

        {{-- <div class="mt-4 pt-4 border-t border-gray-200">
            <form action="{{ route('comments.store', $note) }}" method="POST">
                @csrf
                <textarea name="body" rows="3"
                    class="w-full border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500"
                    placeholder="Add a comment..."></textarea>
                <button type="submit"
                    class="mt-2 w-full px-4 py-2 bg-indigo-600 text-white rounded-md text-sm font-semibold hover:bg-indigo-700">Post</button>
            </form>
        </div>
    </div>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            ClassicEditor
                .create(document.querySelector('#content'))
                .catch(error => {
                    console.error(error);
                });
        });
    </script> --}}
</x-app-layout>

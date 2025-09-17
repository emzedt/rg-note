<div class="py-6">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <h2 class="text-2xl font-bold text-white mb-6">Public Notes</h2>
        
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            @forelse($notes as $note)
                <div class="bg-gray-800 rounded-lg shadow-lg overflow-hidden hover:shadow-xl transition-shadow duration-300">
                    <div class="p-6">
                        <h3 class="text-xl font-bold text-white mb-2 truncate">{{ $note->title }}</h3>
                        <div class="flex items-center text-gray-400 text-sm mb-4">
                            <span class="font-medium text-gray-300">{{ $note->owner->name }}</span>
                            <span class="mx-2">•</span>
                            <span>{{ $note->created_at->format('M d, Y') }}</span>
                        </div>
                        <div class="text-gray-300 mb-4 line-clamp-3">
                            {!! Str::limit(strip_tags($note->content), 150) !!}
                        </div>
                        <div class="flex justify-end">
                            <a href="{{ route('notes.view', $note->id) }}" class="px-4 py-2 bg-indigo-600 text-white rounded-md hover:bg-indigo-500 text-sm">
                                Read More
                            </a>
                        </div>
                    </div>
                </div>
            @empty
                <div class="col-span-3 text-center py-12 text-gray-400">
                    <p class="text-xl">No public notes available yet.</p>
                    <p class="mt-2">Be the first to share a note with the community!</p>
                </div>
            @endforelse
        </div>
        
        <div class="mt-6">
            {{ $notes->links() }}
        </div>
    </div>
</div>
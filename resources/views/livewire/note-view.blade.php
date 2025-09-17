<div class="p-8 bg-white rounded-lg">
    <h1 class="text-3xl font-bold text-gray-900 mb-2">{{ $note->title }}</h1>
    <p class="text-sm text-gray-500 mb-6">By {{ $note->owner->name }} on {{ $note->created_at->format('M d, Y') }}</p>

    <div class="prose max-w-none">
        {!! $note->content !!}
    </div>
</div>

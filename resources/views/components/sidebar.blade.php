<div class="h-full w-64 bg-gray-50 border-r border-gray-200 p-4">
    <h2 class="text-lg font-semibold text-gray-800 mb-4">Workspace</h2>
    <nav class="space-y-2">
        <a href="{{ route('notes.index', ['filter' => 'private']) }}"
            class="flex items-center px-3 py-2 text-gray-700 rounded-md {{ request('filter', 'private') == 'private' ? 'bg-gray-200' : 'hover:bg-gray-100' }}">
            <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24" ...>
                <path ...></path>
            </svg>
            <span>Private</span>
        </a>
        <a href="{{ route('notes.index', ['filter' => 'shared']) }}"
            class="flex items-center px-3 py-2 text-gray-700 rounded-md {{ request('filter') == 'shared' ? 'bg-gray-200' : 'hover:bg-gray-100' }}">
            <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24" ...>
                <path ...></path>
            </svg>
            <span>Shared with me</span>
        </a>
        <a href="{{ route('notes.index', ['filter' => 'public']) }}"
            class="flex items-center px-3 py-2 text-gray-700 rounded-md {{ request('filter') == 'public' ? 'bg-gray-200' : 'hover:bg-gray-100' }}">
            <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24" ...>
                <path ...></path>
            </svg>
            <span>Public</span>
        </a>
    </nav>
</div>

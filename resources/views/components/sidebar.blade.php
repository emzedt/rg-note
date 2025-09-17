<div :class="sidebarOpen ? 'w-64' : 'w-0'"
    class="flex-shrink-0 bg-gray-800 border-r border-gray-700 flex flex-col transition-all duration-300 overflow-hidden">

    <div x-show="sidebarOpen" class="flex-1 flex flex-col">
        <div class="h-16 flex-shrink-0 px-4 flex items-center">
            <div class="flex items-center space-x-2">
                <img class="h-8 w-8 rounded-full"
                    src="https://ui-avatars.com/api/?name={{ urlencode(Auth::user()->name) }}&background=4f46e5&color=fff"
                    alt="Avatar">
                <span class="text-sm font-semibold text-gray-200">{{ Auth::user()->name }}'s Workspace</span>
            </div>
        </div>

        <nav class="flex-1 px-2 py-4 space-y-2">
            <a href="{{ route('dashboard') }}"
                class="flex items-center px-3 py-2 text-sm font-medium rounded-md {{-- Logika untuk highlight --}}
                    {{ request()->routeIs('dashboard') ? 'bg-gray-700 text-white' : 'text-gray-300 hover:bg-gray-700 hover:text-white' }}">
                <svg class="w-5 h-5 mr-3" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                    stroke-width="1.5" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round"
                        d="M3.75 6A2.25 2.25 0 016 3.75h2.25A2.25 2.25 0 0110.5 6v2.25a2.25 2.25 0 01-2.25 2.25H6a2.25 2.25 0 01-2.25-2.25V6zM3.75 15.75A2.25 2.25 0 016 13.5h2.25a2.25 2.25 0 012.25 2.25V18a2.25 2.25 0 01-2.25 2.25H6A2.25 2.25 0 013.75 18v-2.25zM13.5 6a2.25 2.25 0 012.25-2.25H18A2.25 2.25 0 0120.25 6v2.25A2.25 2.25 0 0118 10.5h-2.25a2.25 2.25 0 01-2.25-2.25V6zM13.5 15.75a2.25 2.25 0 012.25-2.25H18a2.25 2.25 0 012.25 2.25V18A2.25 2.25 0 0118 20.25h-2.25A2.25 2.25 0 0113.5 18v-2.25z" />
                </svg>
                <span>Dashboard</span>
            </a>
            <hr class="border-gray-700 my-2">
            <a href="{{ route('notes.index', ['filter' => 'private']) }}"
                class="flex items-center px-3 py-2 text-sm font-medium rounded-md {{ request()->routeIs('notes.index') && request('filter', 'private') == 'private' ? 'bg-gray-700 text-white' : 'text-gray-300 hover:bg-gray-700 hover:text-white' }}">
                <svg class="w-5 h-5 mr-3" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                    stroke-width="1.5" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round"
                        d="M16.5 10.5V6.75a4.5 4.5 0 10-9 0v3.75m-.75 11.25h10.5a2.25 2.25 0 002.25-2.25v-6.75a2.25 2.25 0 00-2.25-2.25H6.75a2.25 2.25 0 00-2.25 2.25v6.75a2.25 2.25 0 002.25 2.25z" />
                </svg>
                <span>Private</span>
            </a>
            <a href="{{ route('notes.index', ['filter' => 'shared']) }}"
                class="flex items-center px-3 py-2 text-sm font-medium rounded-md {{ request()->routeIs('notes.index') && request('filter') == 'shared' ? 'bg-gray-700 text-white' : 'text-gray-300 hover:bg-gray-700 hover:text-white' }}">
                <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 mr-3" viewBox="0 0 24 24">
                    <path fill="currentColor" fill-rule="evenodd"
                        d="M16.67 13.13C18.04 14.06 19 15.32 19 17v3h4v-3c0-2.18-3.57-3.47-6.33-3.87z" />
                    <circle cx="9" cy="8" r="4" fill="currentColor" fill-rule="evenodd" />
                    <path fill="currentColor" fill-rule="evenodd"
                        d="M15 12c2.21 0 4-1.79 4-4s-1.79-4-4-4c-.47 0-.91.1-1.33.24a5.98 5.98 0 0 1 0 7.52c.42.14.86.24 1.33.24zm-6 1c-2.67 0-8 1.34-8 4v3h16v-3c0-2.66-5.33-4-8-4z" />
                </svg>
                <span>Shared with me</span>
            </a>
            <a href="{{ route('notes.index', ['filter' => 'public']) }}"
                class="flex items-center px-3 py-2 text-sm font-medium rounded-md {{ request()->routeIs('notes.index') && request('filter') == 'public' ? 'bg-gray-700 text-white' : 'text-gray-300 hover:bg-gray-700 hover:text-white' }}">
                <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 mr-3" viewBox="0 0 24 24" fill="none">
                    <g fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                        stroke-width="2">
                        <path d="M3 12a9 9 0 1 0 18 0a9 9 0 0 0-18 0m.6-3h16.8M3.6 15h16.8" />
                        <path d="M11.5 3a17 17 0 0 0 0 18m1-18a17 17 0 0 1 0 18" />
                    </g>
                </svg>
                <span>Public</span>
            </a>
            <hr class="border-gray-700 my-2">
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <a href="{{ route('logout') }}" onclick="event.preventDefault(); this.closest('form').submit();"
                    class="flex items-center w-full px-3 py-2 text-sm font-medium rounded-md text-gray-300 hover:bg-gray-700 hover:text-white">
                    <svg class="w-5 h-5 mr-3" xmlns="http://www.w.org/2000/svg" fill="none" viewBox="0 0 24 24"
                        stroke-width="1.5" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="M15.75 9V5.25A2.25 2.25 0 0013.5 3h-6a2.25 2.25 0 00-2.25 2.25v13.5A2.25 2.25 0 007.5 21h6a2.25 2.25 0 002.25-2.25V15m3 0l3-3m0 0l-3-3m3 3H9" />
                    </svg>
                    <span>Logout</span>
                </a>
            </form>
        </nav>
    </div>
</div>

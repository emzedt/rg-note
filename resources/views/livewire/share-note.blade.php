<div class="p-6 bg-gray-800 rounded-lg text-white w-full max-w-2xl mx-auto">
    <h2 class="text-2xl font-bold mb-4">Share Note: {{ $note->title }}</h2>

    @if (session()->has('message'))
        <div class="bg-green-600 text-white p-3 rounded mb-4">
            {{ session('message') }}
        </div>
    @endif

    @if (session()->has('error'))
        <div class="bg-red-600 text-white p-3 rounded mb-4">
            {{ session('error') }}
        </div>
    @endif

    <form wire:submit.prevent="shareWithUser" class="mb-6">
        <div class="flex flex-col md:flex-row gap-4">
            <div class="flex-grow">
                <label for="email" class="block text-sm font-medium text-gray-300 mb-1">User Email</label>
                <input type="email" wire:model="email" id="email" placeholder="Enter user email"
                    class="w-full bg-gray-700 border-gray-600 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 text-white">
                @error('email')
                    <span class="text-red-500 text-xs">{{ $message }}</span>
                @enderror
            </div>
            <div class="w-full md:w-1/3">
                <label for="role" class="block text-sm font-medium text-gray-300 mb-1">Role</label>
                <select wire:model="role" id="role"
                    class="w-full bg-gray-700 border-gray-600 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 text-white">
                    <option value="viewer">Viewer</option>
                    <option value="editor">Editor</option>
                </select>
            </div>
            <div class="self-end">
                <button type="submit" class="px-4 py-2 bg-indigo-600 text-white rounded-md hover:bg-indigo-500">
                    Share
                </button>
            </div>
        </div>
    </form>

    <div class="mt-8">
        <h3 class="text-xl font-semibold mb-4">Shared With</h3>
        @if (count($sharedUsers) > 0)
            <div class="bg-gray-700 rounded-lg overflow-hidden">
                <table class="min-w-full divide-y divide-gray-600">
                    <thead class="bg-gray-900">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-300 uppercase tracking-wider">
                                User</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-300 uppercase tracking-wider">
                                Role</th>
                            <th class="px-6 py-3 text-right text-xs font-medium text-gray-300 uppercase tracking-wider">
                                Actions</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-600">
                        @foreach ($sharedUsers as $user)
                            <tr>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="flex items-center">
                                        <div>
                                            <div class="text-sm font-medium text-white">{{ $user->name }}</div>
                                            <div class="text-sm text-gray-400">{{ $user->email }}</div>
                                        </div>
                                    </div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <select wire:change="updateUserRole({{ $user->id }}, $event.target.value)"
                                        class="bg-gray-800 border-gray-700 rounded-md text-sm text-white">
                                        <option value="viewer" {{ $user->pivot->role === 'viewer' ? 'selected' : '' }}>
                                            Viewer</option>
                                        <option value="editor" {{ $user->pivot->role === 'editor' ? 'selected' : '' }}>
                                            Editor</option>
                                    </select>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                    <button wire:click="removeSharedUser({{ $user->id }})"
                                        class="text-red-400 hover:text-red-300">
                                        Remove
                                    </button>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @else
            <div class="text-gray-400 text-center py-4">
                This note hasn't been shared with anyone yet.
            </div>
        @endif
    </div>

    <div class="mt-6 flex justify-end">
        <a href="{{ url()->previous() }}" class="px-4 py-2 bg-gray-600 text-gray-200 rounded-md hover:bg-gray-500">
            Back to Note
        </a>
    </div>
</div>

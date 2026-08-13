<x-app-layout>
    <x-slot name="header"><h2 class="font-semibold text-xl text-gray-800 leading-tight">Settings — Users</h2></x-slot>
    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                @if(session('success'))
                    <div class="mb-4 p-3 bg-green-100 text-green-800 rounded">{{ session('success') }}</div>
                @endif
                @if(session('error'))
                    <div class="mb-4 p-3 bg-red-100 text-red-800 rounded">{{ session('error') }}</div>
                @endif

                <a href="{{ route('settings.create') }}" class="inline-block mb-4 px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-700">Add User</a>

                <table class="w-full text-left border-collapse">
                    <thead>
                        <tr class="border-b">
                            <th class="py-2">Name</th>
                            <th class="py-2">Role</th>
                            <th class="py-2">Login method</th>
                            <th class="py-2">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($users as $user)
                            <tr class="border-b">
                                <td class="py-2">{{ $user->name }}</td>
                                <td class="py-2">{{ ucfirst($user->role) }}</td>
                                <td class="py-2">{{ $user->role === 'admin' ? 'Email + password' : '6-digit PIN' }}</td>
                                <td class="py-2">
                                    <a href="{{ route('settings.edit', $user) }}" class="text-blue-600 hover:underline">Edit</a>
                                    @if($user->id !== auth()->id())
                                        <form action="{{ route('settings.destroy', $user) }}" method="POST" class="inline" onsubmit="return confirm('Remove this user?');">
                                            @csrf @method('DELETE')
                                            <button type="submit" class="text-red-600 hover:underline ml-2">Remove</button>
                                        </form>
                                    @endif
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</x-app-layout>
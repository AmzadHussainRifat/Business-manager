<x-app-layout>
    <x-slot name="header"><h2 class="font-serif text-2xl text-ink leading-tight">Settings — Users</h2></x-slot>
    <div class="py-12">
        <div class="max-w-6xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white border border-hairline overflow-hidden shadow-sm sm:rounded-lg p-6">
                @if(session('success'))
                    <div class="mb-4 p-3 bg-paper border border-positive text-positive rounded-lg">{{ session('success') }}</div>
                @endif
                @if(session('error'))
                    <div class="mb-4 p-3 bg-white border border-negative text-negative rounded-lg">{{ session('error') }}</div>
                @endif

                <a href="{{ route('settings.create') }}" class="inline-block mb-4 px-4 py-2 bg-ledger text-paper rounded-md hover:bg-ink transition">Add user</a>

                <table class="w-full text-left border-collapse">
                    <thead>
                        <tr class="border-b border-hairline text-xs uppercase tracking-widest text-gray-500">
                            <th class="py-2">Name</th>
                            <th class="py-2">Role</th>
                            <th class="py-2">Login method</th>
                            <th class="py-2">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($users as $user)
                            <tr class="border-b border-hairline">
                                <td class="py-2 text-ink">{{ $user->name }}</td>
                                <td class="py-2 text-ink">{{ ucfirst($user->role) }}</td>
                                <td class="py-2 text-gray-500">{{ $user->role === 'admin' ? 'Email + password' : '6-digit PIN' }}</td>
                                <td class="py-2">
                                    <a href="{{ route('settings.edit', $user) }}" class="text-ledger hover:underline">Edit</a>
                                    @if($user->id !== auth()->id())
                                        <form action="{{ route('settings.destroy', $user) }}" method="POST" class="inline" onsubmit="return confirm('Remove this user?');">
                                            @csrf @method('DELETE')
                                            <button type="submit" class="text-negative hover:underline ml-2">Remove</button>
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
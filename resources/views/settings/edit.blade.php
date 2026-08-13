<x-app-layout>
    <x-slot name="header"><h2 class="font-semibold text-xl text-gray-800 leading-tight">Edit User</h2></x-slot>
    <div class="py-12">
        <div class="max-w-2xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                <p class="text-sm text-gray-500 mb-4">Role: {{ ucfirst($user->role) }} (cannot be changed here)</p>

                <form action="{{ route('settings.update', $user) }}" method="POST">
                    @csrf @method('PUT')
                    <div class="mb-4">
                        <label class="block font-medium mb-1">Name</label>
                        <input type="text" name="name" value="{{ old('name', $user->name) }}" class="w-full border rounded p-2">
                        @error('name') <p class="text-red-600 text-sm mt-1">{{ $message }}</p> @enderror
                    </div>

                    @if($user->role === 'staff')
                        <div class="mb-4">
                            <label class="block font-medium mb-1">New PIN (leave blank to keep current)</label>
                            <input type="text" name="pin" inputmode="numeric" maxlength="6" class="w-full border rounded p-2">
                            @error('pin') <p class="text-red-600 text-sm mt-1">{{ $message }}</p> @enderror
                        </div>
                    @else
                        <div class="mb-4">
                            <label class="block font-medium mb-1">New password (leave blank to keep current)</label>
                            <input type="password" name="password" class="w-full border rounded p-2">
                            @error('password') <p class="text-red-600 text-sm mt-1">{{ $message }}</p> @enderror
                        </div>
                    @endif

                    <button type="submit" class="px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-700">Update User</button>
                    <a href="{{ route('settings.index') }}" class="ml-2 text-gray-600 hover:underline">Cancel</a>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>
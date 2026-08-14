<x-app-layout>
    <x-slot name="header"><h2 class="font-serif text-2xl text-ink leading-tight">Edit user</h2></x-slot>
    <div class="py-12">
        <div class="max-w-2xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white border border-hairline overflow-hidden shadow-sm sm:rounded-lg p-6">
                <p class="text-sm text-gray-500 mb-4">Role: <strong class="text-ink">{{ ucfirst($user->role) }}</strong> (cannot be changed here)</p>

                <form action="{{ route('settings.update', $user) }}" method="POST">
                    @csrf @method('PUT')
                    <div class="mb-4">
                        <x-input-label value="Name" />
                        <x-text-input type="text" name="name" value="{{ old('name', $user->name) }}" class="w-full mt-1" />
                        @error('name') <p class="text-negative text-sm mt-1">{{ $message }}</p> @enderror
                    </div>

                    @if($user->role === 'staff')
                        <div class="mb-4">
                            <x-input-label value="New PIN (leave blank to keep current)" />
                            <x-text-input type="text" name="pin" inputmode="numeric" maxlength="6" class="w-full mt-1 font-mono" />
                            @error('pin') <p class="text-negative text-sm mt-1">{{ $message }}</p> @enderror
                        </div>
                    @else
                        <div class="mb-4">
                            <x-input-label value="New password (leave blank to keep current)" />
                            <x-text-input type="password" name="password" class="w-full mt-1" />
                            @error('password') <p class="text-negative text-sm mt-1">{{ $message }}</p> @enderror
                        </div>
                    @endif

                    <x-primary-button>Update user</x-primary-button>
                    <a href="{{ route('settings.index') }}" class="ml-2 text-gray-500 hover:text-ink hover:underline">Cancel</a>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>
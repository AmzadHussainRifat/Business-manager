<x-guest-layout>
    <div class="mb-4 text-lg font-semibold text-center">Select your name</div>

    <div class="grid grid-cols-2 gap-3">
        @forelse($staff as $person)
            <a href="{{ route('staff-login.pin', $person) }}" class="block bg-white border rounded-lg p-4 text-center hover:bg-gray-50 shadow-sm">
                {{ $person->name }}
            </a>
        @empty
            <p class="col-span-2 text-center text-gray-500">No staff accounts yet.</p>
        @endforelse
    </div>

    <div class="mt-6 text-center">
        <a href="{{ route('login') }}" class="text-sm text-gray-500 hover:underline">Admin login instead</a>
    </div>
</x-guest-layout>
<x-guest-layout>
    <div class="mb-4 text-lg font-semibold text-center">Hi, {{ $user->name }}</div>
    <p class="text-sm text-gray-500 text-center mb-4">Enter your 6-digit PIN</p>

    @if($errors->any())
        <div class="mb-4 p-3 bg-red-100 text-red-800 rounded text-sm text-center">
            {{ $errors->first() }}
        </div>
    @endif

    <form method="POST" action="{{ route('staff-login.attempt', $user) }}">
        @csrf
        <input
            type="password"
            name="pin"
            inputmode="numeric"
            maxlength="6"
            pattern="\d{6}"
            autofocus
            class="w-full text-center text-2xl tracking-widest border rounded p-3 mb-4"
            placeholder="______"
        >
        <button type="submit" class="w-full px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-700">
            Log in
        </button>
    </form>

    <div class="mt-6 text-center">
        <a href="{{ route('staff-login.index') }}" class="text-sm text-gray-500 hover:underline">Not you? Go back</a>
    </div>
</x-guest-layout>
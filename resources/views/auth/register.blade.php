<x-guest-layout>
    <div x-data="{ showHelp: false }">
        <div class="flex items-center justify-between mb-4 pb-3 border-b border-hairline">
            <h2 class="font-serif text-lg text-ink">Register</h2>
            <button type="button" @click="showHelp = !showHelp"
                    class="w-6 h-6 flex items-center justify-center rounded-full text-gray-400 hover:text-ink hover:bg-paper text-xs transition"
                    aria-label="Help">
                ?
            </button>
        </div>
        <div x-show="showHelp" x-cloak class="mb-4 p-3 bg-paper border border-hairline rounded-lg text-sm text-ink">
            This is a one-time setup step. No admin account exists yet — the account you create here becomes the administrator. Once created, this page will no longer be accessible.
        </div>

        <form method="POST" action="{{ route('register') }}">
            @csrf
            <div>
                <x-input-label for="name" :value="__('Name')" />
                <x-text-input id="name" class="block mt-1 w-full" type="text" name="name" :value="old('name')" required autofocus autocomplete="name" />
                <x-input-error :messages="$errors->get('name')" class="mt-2" />
            </div>
            <div class="mt-4">
                <x-input-label for="email" :value="__('Email')" />
                <x-text-input id="email" class="block mt-1 w-full" type="email" name="email" :value="old('email')" required autocomplete="username" />
                <x-input-error :messages="$errors->get('email')" class="mt-2" />
            </div>
            <div class="mt-4">
                <x-input-label for="password" :value="__('Password')" />
                <x-text-input id="password" class="block mt-1 w-full"
                                type="password"
                                name="password"
                                required autocomplete="new-password" />
                <x-input-error :messages="$errors->get('password')" class="mt-2" />
            </div>
            <div class="mt-4">
                <x-input-label for="password_confirmation" :value="__('Confirm Password')" />
                <x-text-input id="password_confirmation" class="block mt-1 w-full"
                                type="password"
                                name="password_confirmation" required autocomplete="new-password" />
                <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2" />
            </div>
            <div class="flex items-center justify-end mt-4">
                <a class="underline text-sm text-gray-600 hover:text-ink rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-ledger" href="{{ route('login') }}">
                    {{ __('Already registered?') }}
                </a>
                <x-primary-button class="ms-4">
                    {{ __('Register') }}
                </x-primary-button>
            </div>
        </form>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const card = document.getElementById('auth-card');
            if (card) {
                card.classList.remove('h-[420px]');
                card.style.height = 'auto';
            }
        });
    </script>
</x-guest-layout>
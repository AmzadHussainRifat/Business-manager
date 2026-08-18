<x-guest-layout>
    @php
        $initialSelected = 'null';
        if ($errors->has('pin') && old('user_id')) {
            $initialSelected = (int) old('user_id');
        } elseif ($errors->has('email') || $errors->has('password')) {
            $initialSelected = "'admin'";
        }
    @endphp

    <div x-data="{ showHelp: false }" class="mb-2">
        <div class="flex justify-end">
            <button type="button" @click="showHelp = !showHelp"
                    class="w-6 h-6 flex items-center justify-center rounded-full text-gray-400 hover:text-ink hover:bg-paper text-xs transition"
                    aria-label="Help">
                ?
            </button>
        </div>
        <div x-show="showHelp" x-cloak class="p-3 bg-paper border border-hairline rounded-lg text-sm text-ink -mt-1">
            Tap a name to log in with your PIN, or tap Admin to log in with email and password.
        </div>
    </div>

    <div x-data="{ selected: {{ $initialSelected }}, staffList: {{ $staff->map(fn($s) => ['id' => $s->id, 'name' => $s->name, 'url' => route('staff-login.attempt', $s)])->toJson() }} }">
        <div class="grid">

            <!-- Picker -->
            <div class="[grid-area:1/1]"
                 x-show="selected === null"
                 x-transition:enter="transition ease-out duration-100"
                 x-transition:enter-start="opacity-0"
                 x-transition:enter-end="opacity-100"
                 x-transition:leave="transition ease-in duration-0"
                 x-transition:leave-start="opacity-100"
                 x-transition:leave-end="opacity-0">
                <div class="flex justify-center mb-1">
                    <x-application-logo class="h-14 w-auto fill-current text-ledger" />
                </div>
                <p class="text-xs uppercase tracking-widest text-gray-500 text-left px-4 mb-4">{{ __('Log in as') }}</p>

                <div class="max-h-52 overflow-y-auto flex flex-col gap-2 pr-1">
                    <button type="button"
                            @click="selected = 'admin'"
                            class="w-full text-center px-4 py-3 rounded-xl bg-ink text-paper font-medium text-sm shadow-sm hover:opacity-90 active:scale-[0.98] transition duration-150 ease-in-out">
                        Admin
                    </button>

                    @forelse($staff as $person)
                        <button type="button"
                                @click="selected = {{ $person->id }}"
                                class="w-full text-center px-4 py-3 rounded-xl bg-white border border-hairline text-ink font-medium text-sm shadow-sm hover:border-ledger hover:bg-paper active:scale-[0.98] transition duration-150 ease-in-out">
                            {{ $person->name }}
                        </button>
                    @empty
                        <p class="text-center text-gray-500 text-sm py-4">No staff accounts yet.</p>
                    @endforelse
                </div>
            </div>

            <!-- Staff PIN form -->
            <template x-if="selected !== null && selected !== 'admin'">
                <div class="[grid-area:1/1]"
                     x-transition:enter="transition ease-out duration-100"
                     x-transition:enter-start="opacity-0"
                     x-transition:enter-end="opacity-100"
                     x-transition:leave="transition ease-in duration-0"
                     x-transition:leave-start="opacity-100"
                     x-transition:leave-end="opacity-0">
                    <div class="flex items-center gap-2 mb-4 pb-3 border-b border-hairline">
                        <button type="button" @click="selected = null" class="text-gray-500 hover:text-ink transition" aria-label="Back">
                            &larr;
                        </button>
                        <h2 class="font-serif text-lg text-ink"
                            x-text="'Hi, ' + (staffList.find(s => s.id === selected)?.name ?? '')"></h2>
                    </div>

                    <form method="POST" :action="staffList.find(s => s.id === selected)?.url">
                        @csrf
                        <input type="hidden" name="user_id" :value="selected">
                        <x-input-label for="pin" value="Enter your 6-digit PIN" />
                        <input
                            type="password"
                            name="pin"
                            id="pin"
                            inputmode="numeric"
                            maxlength="6"
                            pattern="\d{6}"
                            autofocus
                            class="block mt-2 w-full text-center text-2xl tracking-widest border-hairline bg-white text-ink focus:border-ledger focus:ring-ledger rounded-xl shadow-sm"
                            placeholder="______"
                        >
                        <x-input-error :messages="$errors->get('pin')" class="mt-2" />
                        <x-primary-button class="w-full justify-center mt-4 rounded-xl">
                            {{ __('Log in') }}
                        </x-primary-button>
                    </form>
                </div>
            </template>

            <!-- Admin login form -->
            <div class="[grid-area:1/1]"
                 x-show="selected === 'admin'"
                 x-transition:enter="transition ease-out duration-100"
                 x-transition:enter-start="opacity-0"
                 x-transition:enter-end="opacity-100"
                 x-transition:leave="transition ease-in duration-0"
                 x-transition:leave-start="opacity-100"
                 x-transition:leave-end="opacity-0">
                <div class="flex items-center gap-2 mb-4 pb-3 border-b border-hairline">
                    <button type="button" @click="selected = null" class="text-gray-500 hover:text-ink transition" aria-label="Back">
                        &larr;
                    </button>
                    <h2 class="font-serif text-lg text-ink">{{ __('Admin login') }}</h2>
                </div>

                <x-auth-session-status class="mb-4" :status="session('status')" />

                <form method="POST" action="{{ route('login') }}">
                    @csrf
                    <div>
                        <x-input-label for="email" :value="__('Email')" />
                        <x-text-input id="email" class="block mt-1 w-full rounded-xl" type="email" name="email" :value="old('email')" autocomplete="username" />
                        <x-input-error :messages="$errors->get('email')" class="mt-2" />
                    </div>

                    <div class="mt-4">
                        <x-input-label for="password" :value="__('Password')" />
                        <x-text-input id="password" class="block mt-1 w-full rounded-xl"
                                        type="password"
                                        name="password"
                                        autocomplete="current-password"/>
                        <x-input-error :messages="$errors->get('password')" class="mt-2" />
                    </div>

                    <div class="block mt-4">
                        <label for="remember_me" class="inline-flex items-center">
                            <input id="remember_me" type="checkbox" class="rounded border-hairline text-ledger shadow-sm focus:ring-ledger" name="remember">
                            <span class="ms-2 text-sm text-gray-600">{{ __('Remember me') }}</span>
                        </label>
                    </div>

                    <div class="flex items-center justify-end mt-4">
                        @if (Route::has('password.request'))
                            <a class="underline text-sm text-gray-600 hover:text-ink rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-ledger" href="{{ route('password.request') }}">
                                {{ __('Forgot your password?') }}
                            </a>
                        @endif
                        <x-primary-button class="ms-3 rounded-xl">
                            {{ __('Log in') }}
                        </x-primary-button>
                    </div>
                </form>
            </div>

        </div>
    </div>
</x-guest-layout>
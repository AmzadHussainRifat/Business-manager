<x-app-layout>
    <x-slot name="header"><h2 class="font-serif text-2xl text-ink leading-tight">Add user</h2></x-slot>
    <div class="py-12">
        <div class="max-w-2xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white border border-hairline overflow-hidden shadow-sm sm:rounded-lg p-6">
                <form action="{{ route('settings.store') }}" method="POST" x-data="{ role: 'staff' }">
                    @csrf
                    <div class="mb-4">
                        <x-input-label value="Name" />
                        <x-text-input type="text" name="name" value="{{ old('name') }}" class="w-full mt-1" />
                        @error('name') <p class="text-negative text-sm mt-1">{{ $message }}</p> @enderror
                    </div>

                    <div class="mb-4">
                        <x-input-label value="Role" />
                        <select name="role" id="role-select" class="w-full mt-1 border-hairline bg-white text-ink focus:border-ledger focus:ring-ledger rounded-md shadow-sm pl-2 pr-8 py-2" onchange="toggleFields()">
                            <option value="staff" {{ old('role', 'staff') === 'staff' ? 'selected' : '' }}>Staff (PIN login)</option>
                            <option value="admin" {{ old('role') === 'admin' ? 'selected' : '' }}>Admin (email + password)</option>
                        </select>
                    </div>

                    <div id="staff-fields" class="mb-4">
                        <x-input-label value="6-digit PIN" />
                        <x-text-input type="text" name="pin" inputmode="numeric" maxlength="6" value="{{ old('pin') }}" class="w-full mt-1 font-mono" />
                        @error('pin') <p class="text-negative text-sm mt-1">{{ $message }}</p> @enderror
                    </div>

                    <div id="admin-fields" class="mb-4" style="display:none">
                        <x-input-label value="Email" />
                        <x-text-input type="email" name="email" value="{{ old('email') }}" class="w-full mt-1 mb-3" />
                        @error('email') <p class="text-negative text-sm mt-1">{{ $message }}</p> @enderror

                        <x-input-label value="Password" />
                        <x-text-input type="password" name="password" class="w-full mt-1" />
                        @error('password') <p class="text-negative text-sm mt-1">{{ $message }}</p> @enderror
                    </div>

                    <x-primary-button>Save user</x-primary-button>
                    <a href="{{ route('settings.index') }}" class="ml-2 text-gray-500 hover:text-ink hover:underline">Cancel</a>
                </form>
            </div>
        </div>
    </div>

    <script>
        function toggleFields() {
            const role = document.getElementById('role-select').value;
            document.getElementById('staff-fields').style.display = role === 'staff' ? 'block' : 'none';
            document.getElementById('admin-fields').style.display = role === 'admin' ? 'block' : 'none';
        }
        document.addEventListener('DOMContentLoaded', toggleFields);
    </script>
</x-app-layout>
<x-app-layout>
    <x-slot name="header"><h2 class="font-semibold text-xl text-gray-800 leading-tight">Add User</h2></x-slot>
    <div class="py-12">
        <div class="max-w-2xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                <form action="{{ route('settings.store') }}" method="POST" x-data="{ role: 'staff' }">
                    @csrf
                    <div class="mb-4">
                        <label class="block font-medium mb-1">Name</label>
                        <input type="text" name="name" value="{{ old('name') }}" class="w-full border rounded p-2">
                        @error('name') <p class="text-red-600 text-sm mt-1">{{ $message }}</p> @enderror
                    </div>

                    <div class="mb-4">
                        <label class="block font-medium mb-1">Role</label>
                        <select name="role" id="role-select" class="w-full border rounded p-2" onchange="toggleFields()">
                            <option value="staff" {{ old('role', 'staff') === 'staff' ? 'selected' : '' }}>Staff (PIN login)</option>
                            <option value="admin" {{ old('role') === 'admin' ? 'selected' : '' }}>Admin (email + password)</option>
                        </select>
                    </div>

                    <div id="staff-fields" class="mb-4">
                        <label class="block font-medium mb-1">6-digit PIN</label>
                        <input type="text" name="pin" inputmode="numeric" maxlength="6" value="{{ old('pin') }}" class="w-full border rounded p-2">
                        @error('pin') <p class="text-red-600 text-sm mt-1">{{ $message }}</p> @enderror
                    </div>

                    <div id="admin-fields" class="mb-4" style="display:none">
                        <label class="block font-medium mb-1">Email</label>
                        <input type="email" name="email" value="{{ old('email') }}" class="w-full border rounded p-2 mb-3">
                        @error('email') <p class="text-red-600 text-sm mt-1">{{ $message }}</p> @enderror

                        <label class="block font-medium mb-1">Password</label>
                        <input type="password" name="password" class="w-full border rounded p-2">
                        @error('password') <p class="text-red-600 text-sm mt-1">{{ $message }}</p> @enderror
                    </div>

                    <button type="submit" class="px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-700">Save User</button>
                    <a href="{{ route('settings.index') }}" class="ml-2 text-gray-600 hover:underline">Cancel</a>
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
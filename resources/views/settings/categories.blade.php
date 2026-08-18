<x-app-layout>
    <x-slot name="header"><h2 class="font-serif text-2xl text-ink leading-tight">Expense categories</h2></x-slot>
    <div class="py-12">
        <div class="max-w-2xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white border border-hairline overflow-hidden shadow-sm sm:rounded-lg p-6">
                @if(session('success'))
                    <div class="mb-4 p-3 bg-paper border border-positive text-positive rounded-lg">{{ session('success') }}</div>
                @endif

                <form action="{{ route('settings.categories.store') }}" method="POST" class="flex gap-2 mb-6">
                    @csrf
                    <div class="flex-1">
                        <x-text-input type="text" name="name" placeholder="e.g. Rent, Utilities" class="w-full" value="{{ old('name') }}" />
                        @error('name') <p class="text-negative text-sm mt-1">{{ $message }}</p> @enderror
                    </div>
                    <x-primary-button>Add</x-primary-button>
                </form>

                <ul class="space-y-2">
                    @forelse($categories as $category)
                        <li class="flex justify-between items-center border border-hairline rounded-lg px-4 py-2">
                            <span class="text-ink">{{ $category->name }}</span>
                            <form action="{{ route('settings.categories.destroy', $category) }}" method="POST" onsubmit="return confirm('Remove this category? Existing expenses will keep their category label.');">
                                @csrf @method('DELETE')
                                <button type="submit" class="text-negative hover:underline text-sm">Remove</button>
                            </form>
                        </li>
                    @empty
                        <li class="text-gray-500 text-sm">No categories added yet. Expenses will only have "Other" available until you add some.</li>
                    @endforelse
                </ul>

                <p class="text-xs text-gray-400 mt-6">"Other" is always available on the Expenses form by default and cannot be removed.</p>

                <a href="{{ route('settings.index') }}" class="inline-block mt-6 text-sm text-gray-500 hover:text-ink hover:underline">&larr; Back to Users</a>
            </div>
        </div>
    </div>
</x-app-layout>
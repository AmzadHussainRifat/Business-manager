<x-app-layout>
    <x-slot name="header"><h2 class="font-serif text-2xl text-ink leading-tight">Add expense</h2></x-slot>
    <div class="py-12">
        <div class="max-w-2xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white border border-hairline overflow-hidden shadow-sm sm:rounded-lg p-6">
                <form action="{{ route('expenses.store') }}" method="POST">
                    @csrf
                    <div class="mb-4">
                        <x-input-label value="Category" />
                        <x-text-input type="text" name="category" value="{{ old('category') }}" class="w-full mt-1" placeholder="e.g. rent, supplies, utilities" />
                        @error('category') <p class="text-negative text-sm mt-1">{{ $message }}</p> @enderror
                    </div>
                    <div class="mb-4">
                        <x-input-label value="Amount" />
                        <x-text-input type="number" step="0.01" name="amount" min="0" value="{{ old('amount') }}" class="w-full mt-1 font-mono" />
                        @error('amount') <p class="text-negative text-sm mt-1">{{ $message }}</p> @enderror
                    </div>
                    <div class="mb-4">
                        <x-input-label value="Description (optional)" />
                        <x-text-input type="text" name="description" value="{{ old('description') }}" class="w-full mt-1" />
                    </div>
                    <div class="mb-4">
                        <x-input-label value="Date" />
                        <x-text-input type="date" name="date" value="{{ old('date', date('Y-m-d')) }}" class="w-full mt-1" />
                        @error('date') <p class="text-negative text-sm mt-1">{{ $message }}</p> @enderror
                    </div>
                    <x-primary-button>Save expense</x-primary-button>
                    <a href="{{ route('expenses.index') }}" class="ml-2 text-gray-500 hover:text-ink hover:underline">Cancel</a>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>
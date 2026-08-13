<x-app-layout>
    <x-slot name="header"><h2 class="font-semibold text-xl text-gray-800 leading-tight">Edit Expense</h2></x-slot>
    <div class="py-12">
        <div class="max-w-2xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                <form action="{{ route('expenses.update', $expense) }}" method="POST">
                    @csrf @method('PUT')
                    <div class="mb-4">
                        <label class="block font-medium mb-1">Category</label>
                        <input type="text" name="category" value="{{ old('category', $expense->category) }}" class="w-full border rounded p-2">
                        @error('category') <p class="text-red-600 text-sm mt-1">{{ $message }}</p> @enderror
                    </div>
                    <div class="mb-4">
                        <label class="block font-medium mb-1">Amount</label>
                        <input type="number" step="0.01" name="amount" min="0" value="{{ old('amount', $expense->amount) }}" class="w-full border rounded p-2">
                        @error('amount') <p class="text-red-600 text-sm mt-1">{{ $message }}</p> @enderror
                    </div>
                    <div class="mb-4">
                        <label class="block font-medium mb-1">Description (optional)</label>
                        <input type="text" name="description" value="{{ old('description', $expense->description) }}" class="w-full border rounded p-2">
                    </div>
                    <div class="mb-4">
                        <label class="block font-medium mb-1">Date</label>
                        <input type="date" name="date" value="{{ old('date', $expense->date->format('Y-m-d')) }}" class="w-full border rounded p-2">
                        @error('date') <p class="text-red-600 text-sm mt-1">{{ $message }}</p> @enderror
                    </div>
                    <button type="submit" class="px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-700">Update Expense</button>
                    <a href="{{ route('expenses.index') }}" class="ml-2 text-gray-600 hover:underline">Cancel</a>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>
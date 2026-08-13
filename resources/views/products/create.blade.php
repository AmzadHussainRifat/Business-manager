<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">Add Product</h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-2xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                <form action="{{ route('products.store') }}" method="POST">
                    @csrf

                    <div class="mb-4">
                        <label class="block font-medium mb-1">Name</label>
                        <input type="text" name="name" value="{{ old('name') }}" class="w-full border rounded p-2">
                        @error('name') <p class="text-red-600 text-sm mt-1">{{ $message }}</p> @enderror
                    </div>

                    <div class="mb-4">
                        <label class="block font-medium mb-1">Barcode (optional)</label>
                        <input type="text" name="barcode" value="{{ old('barcode') }}" class="w-full border rounded p-2">
                        @error('barcode') <p class="text-red-600 text-sm mt-1">{{ $message }}</p> @enderror
                    </div>

                    <div class="mb-4">
                        <label class="block font-medium mb-1">Buying Price</label>
                        <input type="number" step="0.01" name="buying_price" value="{{ old('buying_price') }}" class="w-full border rounded p-2">
                        @error('buying_price') <p class="text-red-600 text-sm mt-1">{{ $message }}</p> @enderror
                    </div>

                    <div class="mb-4">
                        <label class="block font-medium mb-1">Selling Price</label>
                        <input type="number" step="0.01" name="selling_price" value="{{ old('selling_price') }}" class="w-full border rounded p-2">
                        @error('selling_price') <p class="text-red-600 text-sm mt-1">{{ $message }}</p> @enderror
                    </div>

                    <p class="text-sm text-gray-500 mb-4">Product code will be generated automatically.</p>

                    <button type="submit" class="px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-700">
                        Save Product
                    </button>
                    <a href="{{ route('products.index') }}" class="ml-2 text-gray-600 hover:underline">Cancel</a>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>
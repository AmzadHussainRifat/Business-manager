<x-app-layout>
    <x-slot name="header">
        <h2 class="font-serif text-2xl text-ink leading-tight">Edit product</h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-2xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white border border-hairline overflow-hidden shadow-sm sm:rounded-lg p-6">

                <p class="text-sm text-gray-500 mb-4">Product code: <strong class="font-mono text-ink">{{ $product->product_code }}</strong> (cannot be changed)</p>

                <form action="{{ route('products.update', $product) }}" method="POST">
                    @csrf
                    @method('PUT')

                    <div class="mb-4">
                        <x-input-label value="Name" />
                        <x-text-input type="text" name="name" value="{{ old('name', $product->name) }}" class="w-full mt-1" />
                        @error('name') <p class="text-negative text-sm mt-1">{{ $message }}</p> @enderror
                    </div>

                    <div class="mb-4">
                        <x-input-label value="Barcode (optional)" />
                        <x-text-input type="text" name="barcode" value="{{ old('barcode', $product->barcode) }}" class="w-full mt-1" />
                        @error('barcode') <p class="text-negative text-sm mt-1">{{ $message }}</p> @enderror
                    </div>

                    <div class="mb-4">
                        <x-input-label value="Buying price" />
                        <x-text-input type="number" step="0.01" name="buying_price" value="{{ old('buying_price', $product->buying_price) }}" class="w-full mt-1 font-mono" />
                        @error('buying_price') <p class="text-negative text-sm mt-1">{{ $message }}</p> @enderror
                    </div>

                    <div class="mb-4">
                        <x-input-label value="Selling price" />
                        <x-text-input type="number" step="0.01" name="selling_price" value="{{ old('selling_price', $product->selling_price) }}" class="w-full mt-1 font-mono" />
                        @error('selling_price') <p class="text-negative text-sm mt-1">{{ $message }}</p> @enderror
                    </div>

                    <div class="mb-4">
                        <label class="inline-flex items-center text-ink">
                            <input type="checkbox" name="status" value="1" {{ old('status', $product->status) ? 'checked' : '' }} class="mr-2 rounded border-hairline text-ledger focus:ring-ledger">
                            Active
                        </label>
                    </div>

                    <x-primary-button>
                        Update product
                    </x-primary-button>
                    <a href="{{ route('products.index') }}" class="ml-2 text-gray-500 hover:text-ink hover:underline">Cancel</a>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>
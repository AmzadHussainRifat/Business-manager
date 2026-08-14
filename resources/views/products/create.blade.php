<x-app-layout>
    <x-slot name="header">
        <h2 class="font-serif text-2xl text-ink leading-tight">Add product</h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-2xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white border border-hairline overflow-hidden shadow-sm sm:rounded-lg p-6">
                <form action="{{ route('products.store') }}" method="POST">
                    @csrf

                    <div class="mb-4">
                        <x-input-label value="Name" />
                        <x-text-input type="text" name="name" value="{{ old('name') }}" class="w-full mt-1" />
                        @error('name') <p class="text-negative text-sm mt-1">{{ $message }}</p> @enderror
                    </div>

                    <div class="mb-4">
                        <x-input-label value="Barcode (optional)" />
                        <x-text-input type="text" name="barcode" value="{{ old('barcode') }}" class="w-full mt-1" />
                        @error('barcode') <p class="text-negative text-sm mt-1">{{ $message }}</p> @enderror
                    </div>

                    <div class="mb-4">
                        <x-input-label value="Buying price" />
                        <x-text-input type="number" step="0.01" name="buying_price" value="{{ old('buying_price') }}" class="w-full mt-1 font-mono" />
                        @error('buying_price') <p class="text-negative text-sm mt-1">{{ $message }}</p> @enderror
                    </div>

                    <div class="mb-4">
                        <x-input-label value="Selling price" />
                        <x-text-input type="number" step="0.01" name="selling_price" value="{{ old('selling_price') }}" class="w-full mt-1 font-mono" />
                        @error('selling_price') <p class="text-negative text-sm mt-1">{{ $message }}</p> @enderror
                    </div>

                    <p class="text-sm text-gray-500 mb-4">Product code will be generated automatically.</p>

                    <x-primary-button>
                        Save product
                    </x-primary-button>
                    <a href="{{ route('products.index') }}" class="ml-2 text-gray-500 hover:text-ink hover:underline">Cancel</a>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>
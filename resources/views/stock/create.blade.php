<x-app-layout>
    <x-slot name="header"><h2 class="font-serif text-2xl text-ink leading-tight">Log stock movement</h2></x-slot>
    <div class="py-12">
        <div class="max-w-2xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white border border-hairline overflow-hidden shadow-sm sm:rounded-lg p-6">
                <form action="{{ route('stock.store') }}" method="POST">
                    @csrf
                    <div class="mb-4">
                        <x-input-label value="Product" />
                        <select name="product_id" class="w-full mt-1 border-hairline bg-white text-ink focus:border-ledger focus:ring-ledger rounded-md shadow-sm pl-2 pr-8 py-2">
                            @foreach($products as $product)
                                <option value="{{ $product->id }}">{{ $product->name }} (current: {{ $product->quantity }})</option>
                            @endforeach
                        </select>
                        @error('product_id') <p class="text-negative text-sm mt-1">{{ $message }}</p> @enderror
                    </div>
                    <div class="mb-4">
                        <x-input-label value="Type" />
                        <select name="type" id="type-select" class="w-full mt-1 border-hairline bg-white text-ink focus:border-ledger focus:ring-ledger rounded-md shadow-sm pl-2 pr-8 py-2" onchange="toggleCostField()">
                            <option value="in">Shipment in</option>
                            <option value="out">Disposal / removal</option>
                        </select>
                    </div>
                    <div class="mb-4" id="cost-field">
                        <x-input-label value="Price paid per unit" />
                        <x-text-input type="number" step="0.01" name="unit_cost" min="0" value="{{ old('unit_cost') }}" class="w-full mt-1 font-mono" />
                        @error('unit_cost') <p class="text-negative text-sm mt-1">{{ $message }}</p> @enderror
                    </div>
                    <div class="mb-4">
                        <x-input-label value="Quantity" />
                        <x-text-input type="number" name="quantity" min="1" value="{{ old('quantity') }}" class="w-full mt-1 font-mono" />
                        @error('quantity') <p class="text-negative text-sm mt-1">{{ $message }}</p> @enderror
                    </div>
                    <div class="mb-4">
                        <x-input-label value="Reason (optional)" />
                        <x-text-input type="text" name="reason" value="{{ old('reason') }}" class="w-full mt-1" placeholder="e.g. damaged, new shipment" />
                    </div>
                    <div class="mb-4">
                        <x-input-label value="Date" />
                        <x-text-input type="date" name="date" value="{{ old('date', date('Y-m-d')) }}" class="w-full mt-1" />
                    </div>
                    <x-primary-button>Save</x-primary-button>
                    <a href="{{ route('stock.index') }}" class="ml-2 text-gray-500 hover:text-ink hover:underline">Cancel</a>
                </form>
            </div>
        </div>
    </div>

    <script>
        function toggleCostField() {
            const type = document.getElementById('type-select').value;
            document.getElementById('cost-field').style.display = type === 'in' ? 'block' : 'none';
        }
        document.addEventListener('DOMContentLoaded', toggleCostField);
    </script>
</x-app-layout>
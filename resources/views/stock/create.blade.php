<x-app-layout>
    <x-slot name="header"><h2 class="font-semibold text-xl text-gray-800 leading-tight">Log Stock Movement</h2></x-slot>
    <div class="py-12">
        <div class="max-w-2xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                <form action="{{ route('stock.store') }}" method="POST">
                    @csrf
                    <div class="mb-4">
                        <label class="block font-medium mb-1">Product</label>
                        <select name="product_id" class="w-full border rounded p-2">
                            @foreach($products as $product)
                                <option value="{{ $product->id }}">{{ $product->name }} (current: {{ $product->quantity }})</option>
                            @endforeach
                        </select>
                        @error('product_id') <p class="text-red-600 text-sm mt-1">{{ $message }}</p> @enderror
                    </div>
                    <div class="mb-4">
                        <label class="block font-medium mb-1">Type</label>
                        <select name="type" id="type-select" class="w-full border rounded p-2" onchange="toggleCostField()">
                            <option value="in">Shipment in</option>
                            <option value="out">Disposal / removal</option>
                        </select>
                    </div>
                    <div class="mb-4" id="cost-field">
                        <label class="block font-medium mb-1">Price paid per unit</label>
                        <input type="number" step="0.01" name="unit_cost" min="0" value="{{ old('unit_cost') }}" class="w-full border rounded p-2">
                        @error('unit_cost') <p class="text-red-600 text-sm mt-1">{{ $message }}</p> @enderror
                    </div>
                    <div class="mb-4">
                        <label class="block font-medium mb-1">Quantity</label>
                        <input type="number" name="quantity" min="1" value="{{ old('quantity') }}" class="w-full border rounded p-2">
                        @error('quantity') <p class="text-red-600 text-sm mt-1">{{ $message }}</p> @enderror
                    </div>
                    <div class="mb-4">
                        <label class="block font-medium mb-1">Reason (optional)</label>
                        <input type="text" name="reason" value="{{ old('reason') }}" class="w-full border rounded p-2" placeholder="e.g. damaged, new shipment">
                    </div>
                    <div class="mb-4">
                        <label class="block font-medium mb-1">Date</label>
                        <input type="date" name="date" value="{{ old('date', date('Y-m-d')) }}" class="w-full border rounded p-2">
                    </div>
                    <button type="submit" class="px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-700">Save</button>
                    <a href="{{ route('stock.index') }}" class="ml-2 text-gray-600 hover:underline">Cancel</a>
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
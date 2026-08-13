<x-app-layout>
    <x-slot name="header"><h2 class="font-semibold text-xl text-gray-800 leading-tight">Stock</h2></x-slot>
    <div class="py-12">
        <div class="max-w-5xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                @if(session('success'))
                    <div class="mb-4 p-3 bg-green-100 text-green-800 rounded">{{ session('success') }}</div>
                @endif

                <div class="flex justify-between items-center mb-4 gap-4 flex-wrap">
                    <div class="flex gap-2">
                        @if(auth()->user()->canManage('stock_create'))
                            <a href="{{ route('stock.create') }}" class="px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-700 whitespace-nowrap">Log Stock Movement</a>
                        @endif
                        @if(auth()->user()->canManage('stock_history'))
                            <a href="{{ route('stock.history') }}" class="px-4 py-2 bg-gray-200 rounded hover:bg-gray-300 whitespace-nowrap">View History</a>
                        @endif
                    </div>

                    <form method="GET" action="{{ route('stock.index') }}" class="flex gap-2">
                        <input type="text" name="search" value="{{ request('search') }}" placeholder="Search product..." class="border rounded p-2 w-56">
                        <button type="submit" class="px-4 py-2 bg-gray-200 rounded hover:bg-gray-300">Search</button>
                        @if(request('search'))
                            <a href="{{ route('stock.index') }}" class="px-4 py-2 text-gray-600 hover:underline">Clear</a>
                        @endif
                    </form>
                </div>

                <table class="w-full text-left border-collapse">
                    <thead>
                        <tr class="border-b">
                            <th class="py-2">Product</th>
                            <th class="py-2">Quantity</th>
                            <th class="py-2">Latest price</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($products as $product)
                            <tr class="border-b">
                                <td class="py-2">{{ $product->name }}</td>
                                <td class="py-2">{{ $product->quantity }}</td>
                                <td class="py-2">{{ number_format($product->buying_price, 2) }}</td>
                            </tr>
                        @empty
                            <tr><td colspan="3" class="py-4 text-center text-gray-500">No products found.</td></tr>
                        @endforelse
                    </tbody>
                </table>

                <div class="mt-4">
                    {{ $products->links() }}
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
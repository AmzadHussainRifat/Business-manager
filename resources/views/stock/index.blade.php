<x-app-layout>
    <x-slot name="header"><h2 class="font-serif text-2xl text-ink leading-tight">Stock</h2></x-slot>
    <div class="py-12">
        <div class="max-w-6xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white border border-hairline overflow-hidden shadow-sm sm:rounded-lg p-6">
                @if(session('success'))
                    <div class="mb-4 p-3 bg-paper border border-positive text-positive rounded-lg">{{ session('success') }}</div>
                @endif

                <div class="flex justify-between items-center mb-4 gap-4 flex-wrap">
                    <div class="flex gap-2">
                        @if(auth()->user()->canManage('stock_create'))
                            <a href="{{ route('stock.create') }}" class="px-4 py-2 bg-ledger text-paper rounded-md hover:bg-ink transition whitespace-nowrap">Log stock movement</a>
                        @endif
                        @if(auth()->user()->canManage('stock_history'))
                            <a href="{{ route('stock.history') }}" class="px-4 py-2 bg-paper border border-hairline rounded-md hover:bg-white transition whitespace-nowrap">View history</a>
                        @endif
                    </div>

                    <form method="GET" action="{{ route('stock.index') }}" class="flex gap-2">
                        <input type="text" name="search" value="{{ request('search') }}" placeholder="Search product..." class="border border-hairline rounded-md p-2 w-56 focus:outline-none focus:ring-2 focus:ring-ledger focus:border-ledger">
                        <button type="submit" class="px-4 py-2 bg-paper border border-hairline rounded-md hover:bg-white transition">Search</button>
                        @if(request('search'))
                            <a href="{{ route('stock.index') }}" class="px-4 py-2 text-gray-500 hover:text-ink hover:underline">Clear</a>
                        @endif
                    </form>
                </div>

                <table class="w-full text-left border-collapse">
                    <thead>
                        <tr class="border-b border-hairline text-xs uppercase tracking-widest text-gray-500">
                            <th class="py-2">Product</th>
                            <th class="py-2">Quantity</th>
                            <th class="py-2">Latest price</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($products as $product)
                            <tr class="border-b border-hairline">
                                <td class="py-2 text-ink">{{ $product->name }}</td>
                                <td class="py-2 font-mono {{ $product->quantity < 0 ? 'text-negative' : 'text-ink' }}">{{ $product->quantity }}</td>
                                <td class="py-2 font-mono">{{ number_format($product->buying_price, 2) }}</td>
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
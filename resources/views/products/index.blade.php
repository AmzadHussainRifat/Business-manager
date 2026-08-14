<x-app-layout>
    <x-slot name="header">
        <h2 class="font-serif text-2xl text-ink leading-tight">Products</h2>
    </x-slot>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white border border-hairline overflow-hidden shadow-sm sm:rounded-lg p-6">
                @if(session('success'))
                    <div class="mb-4 p-3 bg-paper border border-positive text-positive rounded-lg">
                        {{ session('success') }}
                    </div>
                @endif

                <div class="flex justify-between items-center mb-4 gap-4 flex-wrap">
                    @if(auth()->user()->canManage('products'))
                        <a href="{{ route('products.create') }}" class="px-4 py-2 bg-ledger text-paper rounded-md hover:bg-ink transition whitespace-nowrap">
                            Add Product
                        </a>
                    @endif

                    <form method="GET" action="{{ route('products.index') }}" class="flex gap-2">
                        <input type="text" name="search" value="{{ request('search') }}" placeholder="Search name or code..." class="border border-hairline rounded-md p-2 w-56 focus:outline-none focus:ring-2 focus:ring-ledger focus:border-ledger">
                            <select name="status" class="border border-hairline rounded-md pl-2 pr-8 py-2 focus:outline-none focus:ring-2 focus:ring-ledger focus:border-ledger">                            <option value="">All statuses</option>
                            <option value="active" {{ request('status') === 'active' ? 'selected' : '' }}>Active</option>
                            <option value="inactive" {{ request('status') === 'inactive' ? 'selected' : '' }}>Inactive</option>
                        </select>
                        <button type="submit" class="px-4 py-2 bg-paper border border-hairline rounded-md hover:bg-white transition">Filter</button>
                        @if(request('search') || request('status'))
                            <a href="{{ route('products.index') }}" class="px-4 py-2 text-gray-500 hover:text-ink hover:underline">Clear</a>
                        @endif
                    </form>
                </div>

                <table class="w-full text-left border-collapse">
                    <thead>
                        <tr class="border-b border-hairline text-xs uppercase tracking-widest text-gray-500">
                            <th class="py-2">Product code</th>
                            <th class="py-2">Name</th>
                            <th class="py-2">Barcode</th>
                            <th class="py-2">Buying price</th>
                            <th class="py-2">Selling price</th>
                            <th class="py-2">Status</th>
                            @if(auth()->user()->canManage('products'))
                                <th class="py-2">Actions</th>
                            @endif
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($products as $product)
                            <tr class="border-b border-hairline">
                                <td class="py-2 font-mono text-sm">{{ $product->product_code }}</td>
                                <td class="py-2 text-ink">{{ $product->name }}</td>
                                <td class="py-2 font-mono text-sm text-gray-500">{{ $product->barcode ?? '—' }}</td>
                                <td class="py-2 font-mono">{{ number_format($product->buying_price, 2) }}</td>
                                <td class="py-2 font-mono">{{ number_format($product->selling_price, 2) }}</td>
                                <td class="py-2">
                                    @if($product->status)
                                        <span class="text-positive">Active</span>
                                    @else
                                        <span class="text-gray-500">Inactive</span>
                                    @endif
                                </td>
                                @if(auth()->user()->canManage('products'))
                                    <td class="py-2">
                                        <a href="{{ route('products.edit', $product) }}" class="text-ledger hover:underline">Edit</a>
                                        <form action="{{ route('products.destroy', $product) }}" method="POST" class="inline" onsubmit="return confirm('Delete this product?');">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="text-negative hover:underline ml-2">Delete</button>
                                        </form>
                                    </td>
                                @endif
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" class="py-4 text-center text-gray-500">
                                    @if(request('search') || request('status'))
                                        No products found matching your filters.
                                    @else
                                        No products yet.
                                    @endif
                                </td>
                            </tr>
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
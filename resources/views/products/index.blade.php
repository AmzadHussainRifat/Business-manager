<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">Products</h2>
    </x-slot>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                @if(session('success'))
                    <div class="mb-4 p-3 bg-green-100 text-green-800 rounded">
                        {{ session('success') }}
                    </div>
                @endif

                <div class="flex justify-between items-center mb-4 gap-4 flex-wrap">
                    @if(auth()->user()->canManage('products'))
                        <a href="{{ route('products.create') }}" class="px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-700 whitespace-nowrap">
                            Add Product
                        </a>
                    @endif

                    <form method="GET" action="{{ route('products.index') }}" class="flex gap-2">
                        <input type="text" name="search" value="{{ request('search') }}" placeholder="Search name or code..." class="border rounded p-2 w-56">
                        <select name="status" class="border rounded p-2">
                            <option value="">All statuses</option>
                            <option value="active" {{ request('status') === 'active' ? 'selected' : '' }}>Active</option>
                            <option value="inactive" {{ request('status') === 'inactive' ? 'selected' : '' }}>Inactive</option>
                        </select>
                        <button type="submit" class="px-4 py-2 bg-gray-200 rounded hover:bg-gray-300">Filter</button>
                        @if(request('search') || request('status'))
                            <a href="{{ route('products.index') }}" class="px-4 py-2 text-gray-600 hover:underline">Clear</a>
                        @endif
                    </form>
                </div>

                <table class="w-full text-left border-collapse">
                    <thead>
                        <tr class="border-b">
                            <th class="py-2">Product Code</th>
                            <th class="py-2">Name</th>
                            <th class="py-2">Barcode</th>
                            <th class="py-2">Buying Price</th>
                            <th class="py-2">Selling Price</th>
                            <th class="py-2">Status</th>
                            @if(auth()->user()->canManage('products'))
                                <th class="py-2">Actions</th>
                            @endif
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($products as $product)
                            <tr class="border-b">
                                <td class="py-2">{{ $product->product_code }}</td>
                                <td class="py-2">{{ $product->name }}</td>
                                <td class="py-2">{{ $product->barcode ?? '—' }}</td>
                                <td class="py-2">{{ number_format($product->buying_price, 2) }}</td>
                                <td class="py-2">{{ number_format($product->selling_price, 2) }}</td>
                                <td class="py-2">
                                    @if($product->status)
                                        <span class="text-green-700">Active</span>
                                    @else
                                        <span class="text-gray-500">Inactive</span>
                                    @endif
                                </td>
                                @if(auth()->user()->canManage('products'))
                                    <td class="py-2">
                                        <a href="{{ route('products.edit', $product) }}" class="text-blue-600 hover:underline">Edit</a>
                                        <form action="{{ route('products.destroy', $product) }}" method="POST" class="inline" onsubmit="return confirm('Delete this product?');">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="text-red-600 hover:underline ml-2">Delete</button>
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
<x-app-layout>
    <x-slot name="header"><h2 class="font-serif text-2xl text-ink leading-tight">{{ $customer->name }}</h2></x-slot>
    <div class="py-12">
        <div class="max-w-6xl mx-auto sm:px-6 lg:px-8">
            <a href="{{ route('customers.index') }}" class="text-sm text-gray-500 hover:text-ink hover:underline mb-4 inline-block">&larr; Back to Customers</a>

            <div class="grid grid-cols-2 md:grid-cols-4 gap-4 mb-6">
                <div class="bg-white border border-hairline rounded-lg p-4">
                    <p class="text-xs uppercase tracking-widest text-gray-500 mb-1">Total spent</p>
                    <p class="font-mono text-2xl text-positive">{{ number_format($totalSpent, 2) }}</p>
                </div>
                <div class="bg-white border border-hairline rounded-lg p-4">
                    <p class="text-xs uppercase tracking-widest text-gray-500 mb-1">Orders</p>
                    <p class="font-mono text-2xl text-ink">{{ $orderCount }}</p>
                </div>
                <div class="bg-white border border-hairline rounded-lg p-4">
                    <p class="text-xs uppercase tracking-widest text-gray-500 mb-1">Avg order value</p>
                    <p class="font-mono text-2xl text-ink">{{ number_format($avgOrderValue, 2) }}</p>
                </div>
                <div class="bg-white border border-hairline rounded-lg p-4">
                    <p class="text-xs uppercase tracking-widest text-gray-500 mb-1">Favorite item</p>
                    <p class="text-lg text-ink">{{ $favoriteItem ?? '—' }}</p>
                </div>
            </div>

            <div class="bg-white border border-hairline rounded-lg p-6 mb-6">
                <h3 class="font-serif text-lg text-ink mb-3">Contact</h3>
                <p class="text-sm text-gray-600">Phone: <span class="font-mono">{{ $customer->phone ?? '—' }}</span></p>
                <p class="text-sm text-gray-600">Email: {{ $customer->email ?? '—' }}</p>
                <p class="text-sm text-gray-600 mt-2">
                    Customer since {{ $firstOrder?->created_at->format('M d, Y') ?? '—' }}
                    @if($lastOrder) · Last visit {{ $lastOrder->created_at->format('M d, Y') }} @endif
                </p>
            </div>

            <div class="bg-white border border-hairline overflow-hidden shadow-sm rounded-lg p-6">
                <h3 class="font-serif text-lg text-ink mb-3">Order history</h3>
                <table class="w-full text-left border-collapse">
                    <thead>
                        <tr class="border-b border-hairline text-xs uppercase tracking-widest text-gray-500">
                            <th class="py-2">Date</th>
                            <th class="py-2">Items</th>
                            <th class="py-2">Total</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($customer->sales as $sale)
                            <tr class="border-b border-hairline">
                                <td class="py-2 font-mono text-sm">{{ $sale->created_at->format('M d, Y H:i') }}</td>
                                <td class="py-2 text-sm text-gray-600">
                                    @foreach($sale->items as $item)
                                        {{ $item->product_name }} x{{ $item->quantity }}@if(!$loop->last), @endif
                                    @endforeach
                                </td>
                                <td class="py-2 font-mono">{{ number_format($sale->total_amount, 2) }}</td>
                            </tr>
                        @empty
                            <tr><td colspan="3" class="py-4 text-center text-gray-500">No orders yet.</td></tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</x-app-layout>
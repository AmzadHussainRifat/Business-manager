<x-app-layout>
    <x-slot name="header"><h2 class="font-semibold text-xl text-gray-800 leading-tight">Sales History</h2></x-slot>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">

                <div class="flex justify-between items-start mb-6 gap-4 flex-wrap">
                    @if(auth()->user()->canManage('sales'))
                        <a href="{{ route('sales.index') }}" class="px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-700 whitespace-nowrap">New Sale</a>
                    @endif

                    <form method="GET" action="{{ route('sales.history') }}" class="flex gap-2 flex-wrap items-center">
                        <input type="date" name="from" value="{{ request('from') }}" class="border rounded p-2">
                        <span class="text-gray-400">to</span>
                        <input type="date" name="to" value="{{ request('to') }}" class="border rounded p-2">
                        <input type="number" step="0.01" name="min_amount" value="{{ request('min_amount') }}" placeholder="Min £" class="border rounded p-2 w-24">
                        <input type="number" step="0.01" name="max_amount" value="{{ request('max_amount') }}" placeholder="Max £" class="border rounded p-2 w-24">
                        <label class="flex items-center gap-1 text-sm text-gray-600">
                            <input type="checkbox" name="oversold" value="1" {{ request('oversold') ? 'checked' : '' }}>
                            Oversold only
                        </label>
                        <button type="submit" class="px-4 py-2 bg-gray-200 rounded hover:bg-gray-300">Filter</button>
                        @if(request()->anyFilled(['from', 'to', 'min_amount', 'max_amount', 'oversold']))
                            <a href="{{ route('sales.history') }}" class="px-4 py-2 text-gray-600 hover:underline">Clear</a>
                        @endif
                    </form>
                </div>

                @forelse($sales as $sale)
                    <div class="border-b py-3">
                        <div class="flex justify-between">
                            <span class="font-medium">
                                Sale #{{ $sale->id }} — {{ $sale->created_at->format('M d, Y H:i') }}
                                @if($sale->items->contains('oversold_quantity', '!=', null))
                                    @if($sale->items->contains('is_oversold', true))
                                        <span class="ml-2 text-xs bg-amber-100 text-amber-700 px-2 py-0.5 rounded-full">Oversold — pending</span>
                                    @else
                                        <span class="ml-2 text-xs bg-green-100 text-green-700 px-2 py-0.5 rounded-full">Oversold — resolved</span>
                                    @endif
                                @endif
                            </span>
                            <span class="font-medium">{{ number_format($sale->total_amount, 2) }}</span>
                        </div>
                        <div class="text-sm text-gray-600">
                            Sold by {{ $sale->user->name }}
                            @if($sale->customer_name) · Customer: {{ $sale->customer_name }} @endif
                            @if($sale->customer_phone) ({{ $sale->customer_phone }}) @endif
                            @if($sale->discount_type)
                                · Discount: {{ $sale->discount_type === 'flat' ? number_format($sale->discount_value, 2) : $sale->discount_value.'%' }}
                            @endif
                        </div>
                        <div class="text-sm text-gray-500">
                            Subtotal: {{ number_format($sale->subtotal, 2) }}
                        </div>
                        <ul class="text-sm text-gray-600 mt-1">
                            @foreach($sale->items as $item)
                                <li>{{ $item->product->name ?? $item->product_name }} x{{ $item->quantity }} @ {{ number_format($item->unit_price, 2) }}</li>
                            @endforeach
                        </ul>
                    </div>
                @empty
                    <p class="text-gray-500">No sales found matching your filters.</p>
                @endforelse

                <div class="mt-4">
                    {{ $sales->links() }}
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
<x-app-layout>
    <x-slot name="header"><h2 class="font-serif text-2xl text-ink leading-tight">Sales history</h2></x-slot>
    <div class="py-12">
        <div class="max-w-6xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white border border-hairline overflow-hidden shadow-sm sm:rounded-lg p-6">

                <div class="flex justify-between items-start mb-6 gap-4 flex-wrap">
                    @if(auth()->user()->canManage('sales'))
                        <a href="{{ route('sales.index') }}" class="px-4 py-2 bg-ledger text-paper rounded-md hover:bg-ink transition whitespace-nowrap">New sale</a>
                    @endif

                    <form method="GET" action="{{ route('sales.history') }}" class="flex gap-2 flex-wrap items-center">
                        <input type="date" name="from" value="{{ request('from') }}" class="border border-hairline rounded-md p-2 focus:outline-none focus:ring-2 focus:ring-ledger focus:border-ledger">
                        <span class="text-gray-500">to</span>
                        <input type="date" name="to" value="{{ request('to') }}" class="border border-hairline rounded-md p-2 focus:outline-none focus:ring-2 focus:ring-ledger focus:border-ledger">
                        <input type="number" step="0.01" name="min_amount" value="{{ request('min_amount') }}" placeholder="Min £" class="border border-hairline rounded-md p-2 w-24 font-mono focus:outline-none focus:ring-2 focus:ring-ledger focus:border-ledger">
                        <input type="number" step="0.01" name="max_amount" value="{{ request('max_amount') }}" placeholder="Max £" class="border border-hairline rounded-md p-2 w-24 font-mono focus:outline-none focus:ring-2 focus:ring-ledger focus:border-ledger">
                        <label class="flex items-center gap-1 text-sm text-gray-600">
                            <input type="checkbox" name="oversold" value="1" {{ request('oversold') ? 'checked' : '' }} class="rounded border-hairline text-ledger focus:ring-ledger">
                            Oversold only
                        </label>
                        <button type="submit" class="px-4 py-2 bg-paper border border-hairline rounded-md hover:bg-white transition">Filter</button>
                        @if(request()->anyFilled(['from', 'to', 'min_amount', 'max_amount', 'oversold']))
                            <a href="{{ route('sales.history') }}" class="px-4 py-2 text-gray-500 hover:text-ink hover:underline">Clear</a>
                        @endif
                    </form>
                </div>

                @forelse($sales as $sale)
                    <div class="border-b border-hairline py-3">
                        <div class="flex justify-between">
                            <span class="font-medium text-ink">
                                Sale #{{ $sale->id }} — {{ $sale->created_at->format('M d, Y H:i') }}
                                @if($sale->items->contains('oversold_quantity', '!=', null))
                                    @if($sale->items->contains('is_oversold', true))
                                        <span class="ml-2 text-xs bg-white border border-negative text-negative px-2 py-0.5 rounded-full">Oversold — pending</span>
                                    @else
                                        <span class="ml-2 text-xs bg-white border border-positive text-positive px-2 py-0.5 rounded-full">Oversold — resolved</span>
                                    @endif
                                @endif
                            </span>
                            <span class="font-medium font-mono text-ink">{{ number_format($sale->total_amount, 2) }}</span>
                        </div>
                        <div class="text-sm text-gray-600">
                            Sold by {{ $sale->user->name }}
                            @if($sale->customer_name) · Customer: {{ $sale->customer_name }} @endif
                            @if($sale->customer_phone) ({{ $sale->customer_phone }}) @endif
                            @if($sale->discount_type)
                                · Discount: {{ $sale->discount_type === 'flat' ? number_format($sale->discount_value, 2) : $sale->discount_value.'%' }}
                            @endif
                        </div>
                        <div class="text-sm text-gray-500 font-mono">
                            Subtotal: {{ number_format($sale->subtotal, 2) }}
                        </div>
                        <ul class="text-sm text-gray-600 mt-1">
                            @foreach($sale->items as $item)
                                <li>{{ $item->product->name ?? $item->product_name }} x{{ $item->quantity }} @ <span class="font-mono">{{ number_format($item->unit_price, 2) }}</span></li>
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
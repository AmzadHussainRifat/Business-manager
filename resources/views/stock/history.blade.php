<x-app-layout>
    <x-slot name="header"><h2 class="font-serif text-2xl text-ink leading-tight">Stock history</h2></x-slot>
    <div class="py-12">
        <div class="max-w-6xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white border border-hairline overflow-hidden shadow-sm sm:rounded-lg p-6">
                <a href="{{ route('stock.index') }}" class="text-sm text-gray-500 hover:text-ink hover:underline mb-4 inline-block">&larr; Back to Stock</a>

                <form method="GET" action="{{ route('stock.history') }}" class="flex gap-2 flex-wrap mb-6">
                    <input type="text" name="search" value="{{ request('search') }}" placeholder="Search product..." class="border border-hairline rounded-md p-2 focus:outline-none focus:ring-2 focus:ring-ledger focus:border-ledger">
                    <select name="type" class="border border-hairline rounded-md pl-2 pr-8 py-2 focus:outline-none focus:ring-2 focus:ring-ledger focus:border-ledger">
                        <option value="">All types</option>
                        <option value="in" {{ request('type') === 'in' ? 'selected' : '' }}>In</option>
                        <option value="out" {{ request('type') === 'out' ? 'selected' : '' }}>Out</option>
                    </select>
                    <input type="date" name="from" value="{{ request('from') }}" class="border border-hairline rounded-md p-2 focus:outline-none focus:ring-2 focus:ring-ledger focus:border-ledger">
                    <span class="self-center text-gray-500">to</span>
                    <input type="date" name="to" value="{{ request('to') }}" class="border border-hairline rounded-md p-2 focus:outline-none focus:ring-2 focus:ring-ledger focus:border-ledger">
                    <button type="submit" class="px-4 py-2 bg-paper border border-hairline rounded-md hover:bg-white transition">Filter</button>
                    @if(request()->anyFilled(['search', 'type', 'from', 'to']))
                        <a href="{{ route('stock.history') }}" class="px-4 py-2 text-gray-500 hover:text-ink hover:underline">Clear</a>
                    @endif
                </form>

                <table class="w-full text-left border-collapse">
                    <thead>
                        <tr class="border-b border-hairline text-xs uppercase tracking-widest text-gray-500">
                            <th class="py-2">Date</th>
                            <th class="py-2">Product</th>
                            <th class="py-2">Type</th>
                            <th class="py-2">Quantity</th>
                            <th class="py-2">Reason</th>
                            <th class="py-2">Logged by</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($movements as $m)
                            <tr class="border-b border-hairline">
                                <td class="py-2 font-mono text-sm">{{ $m->date }}</td>
                                <td class="py-2 text-ink">{{ $m->product->name ?? $m->product_name }}</td>
                                <td class="py-2">
                                    @if($m->type === 'in')
                                        <span class="text-positive">In</span>
                                    @else
                                        <span class="text-negative">Out</span>
                                    @endif
                                </td>
                                <td class="py-2 font-mono">{{ $m->quantity }}</td>
                                <td class="py-2 text-gray-500">{{ $m->reason ?? '—' }}</td>
                                <td class="py-2">{{ $m->user->name }}</td>
                            </tr>
                        @empty
                            <tr><td colspan="6" class="py-4 text-center text-gray-500">No movements found.</td></tr>
                        @endforelse
                    </tbody>
                </table>

                <div class="mt-4">
                    {{ $movements->links() }}
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
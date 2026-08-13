<x-app-layout>
    <x-slot name="header"><h2 class="font-semibold text-xl text-gray-800 leading-tight">Stock History</h2></x-slot>
    <div class="py-12">
        <div class="max-w-6xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                <a href="{{ route('stock.index') }}" class="text-sm text-gray-500 hover:underline mb-4 inline-block">&larr; Back to Stock</a>

                <form method="GET" action="{{ route('stock.history') }}" class="flex gap-2 flex-wrap mb-6">
                    <input type="text" name="search" value="{{ request('search') }}" placeholder="Search product..." class="border rounded p-2">
                    <select name="type" class="border rounded p-2">
                        <option value="">All types</option>
                        <option value="in" {{ request('type') === 'in' ? 'selected' : '' }}>In</option>
                        <option value="out" {{ request('type') === 'out' ? 'selected' : '' }}>Out</option>
                    </select>
                    <input type="date" name="from" value="{{ request('from') }}" class="border rounded p-2">
                    <span class="self-center text-gray-400">to</span>
                    <input type="date" name="to" value="{{ request('to') }}" class="border rounded p-2">
                    <button type="submit" class="px-4 py-2 bg-gray-200 rounded hover:bg-gray-300">Filter</button>
                    @if(request()->anyFilled(['search', 'type', 'from', 'to']))
                        <a href="{{ route('stock.history') }}" class="px-4 py-2 text-gray-600 hover:underline">Clear</a>
                    @endif
                </form>

                <table class="w-full text-left border-collapse">
                    <thead>
                        <tr class="border-b">
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
                            <tr class="border-b">
                                <td class="py-2">{{ $m->date }}</td>
                                <td class="py-2">{{ $m->product->name ?? $m->product_name }}</td>
                                <td class="py-2">
                                    @if($m->type === 'in')
                                        <span class="text-green-700">In</span>
                                    @else
                                        <span class="text-red-700">Out</span>
                                    @endif
                                </td>
                                <td class="py-2">{{ $m->quantity }}</td>
                                <td class="py-2">{{ $m->reason ?? '—' }}</td>
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
<x-app-layout>
    <x-slot name="header"><h2 class="font-semibold text-xl text-gray-800 leading-tight">Reports</h2></x-slot>
    <div class="py-12">
        <div class="max-w-5xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">

                <form method="GET" action="{{ route('reports.index') }}" class="flex gap-2 items-end mb-6">
                    <div>
                        <label class="block text-sm font-medium mb-1">Period</label>
                        <select name="period" class="border rounded p-2">
                            <option value="daily" {{ $period === 'daily' ? 'selected' : '' }}>Daily</option>
                            <option value="weekly" {{ $period === 'weekly' ? 'selected' : '' }}>Weekly</option>
                        </select>
                    </div>
                    <div>
                        <label class="block text-sm font-medium mb-1">Date</label>
                        <input type="date" name="date" value="{{ request('date', now()->toDateString()) }}" class="border rounded p-2">
                    </div>
                    <button type="submit" class="px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-700">View</button>
                </form>

                <p class="text-sm text-gray-500 mb-6">
                    Showing: {{ $start->format('M d, Y') }} @if($period === 'weekly') – {{ $end->format('M d, Y') }} @endif
                </p>

                <h3 class="font-semibold text-lg mb-3">Financial Summary</h3>
                <table class="w-full text-left border-collapse mb-8">
                    <tbody>
                        <tr class="border-b"><td class="py-2">Revenue</td><td class="py-2 text-right">{{ number_format($revenue, 2) }}</td></tr>
                        <tr class="border-b"><td class="py-2">Cost of Goods Sold (COGS)</td><td class="py-2 text-right">−{{ number_format($cogs, 2) }}</td></tr>
                        <tr class="border-b font-medium"><td class="py-2">Gross Profit</td><td class="py-2 text-right">{{ number_format($grossProfit, 2) }}</td></tr>
                        <tr class="border-b"><td class="py-2">Expenses</td><td class="py-2 text-right">−{{ number_format($totalExpenses, 2) }}</td></tr>
                        <tr class="border-b font-semibold text-base {{ $netProfit >= 0 ? 'text-green-700' : 'text-red-700' }}">
                            <td class="py-2">Net Profit</td><td class="py-2 text-right">{{ number_format($netProfit, 2) }}</td>
                        </tr>
                    </tbody>
                </table>

                <p class="text-sm text-gray-500 mb-8">
                    Restocking spend this period (informational only, already reflected in COGS above): {{ number_format($restockSpend, 2) }}
                </p>

                <div class="grid grid-cols-2 gap-8 mb-8">
                    <div>
                        <h3 class="font-semibold text-lg mb-3">Best Sellers</h3>
                        <table class="w-full text-left border-collapse">
                            <thead><tr class="border-b"><th class="py-2">Product</th><th class="py-2">Qty Sold</th></tr></thead>
                            <tbody>
                                @forelse($bestSellers as $name => $qty)
                                    <tr class="border-b"><td class="py-2">{{ $name }}</td><td class="py-2">{{ $qty }}</td></tr>
                                @empty
                                    <tr><td colspan="2" class="py-2 text-gray-500">No sales this period.</td></tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                    <div>
                        <h3 class="font-semibold text-lg mb-3">Worst Sellers</h3>
                        <table class="w-full text-left border-collapse">
                            <thead><tr class="border-b"><th class="py-2">Product</th><th class="py-2">Qty Sold</th></tr></thead>
                            <tbody>
                                @forelse($worstSellers as $name => $qty)
                                    <tr class="border-b"><td class="py-2">{{ $name }}</td><td class="py-2">{{ $qty }}</td></tr>
                                @empty
                                    <tr><td colspan="2" class="py-2 text-gray-500">No sales this period.</td></tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>

                <h3 class="font-semibold text-lg mb-3">Expenses by Category</h3>
                <table class="w-full text-left border-collapse">
                    <thead><tr class="border-b"><th class="py-2">Category</th><th class="py-2">Total</th></tr></thead>
                    <tbody>
                        @forelse($expensesByCategory as $category => $amount)
                            <tr class="border-b"><td class="py-2">{{ $category }}</td><td class="py-2">{{ number_format($amount, 2) }}</td></tr>
                        @empty
                            <tr><td colspan="2" class="py-2 text-gray-500">No expenses this period.</td></tr>
                        @endforelse
                    </tbody>
                </table>

                <p class="text-xs text-gray-400 mt-8">Charts and predictive trends planned for a future update.</p>
            </div>
        </div>
    </div>
</x-app-layout>
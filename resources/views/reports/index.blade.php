<x-app-layout>
    <x-slot name="header"><h2 class="font-serif text-2xl text-ink leading-tight">Reports</h2></x-slot>
    <div class="py-12">
        <div class="max-w-6xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white border border-hairline overflow-hidden shadow-sm sm:rounded-lg p-6">

                <form method="GET" action="{{ route('reports.index') }}" class="flex gap-2 items-end mb-6">
                    <div>
                        <x-input-label value="Period" />
                        <select name="period" class="border-hairline bg-white text-ink focus:border-ledger focus:ring-ledger rounded-md shadow-sm pl-2 pr-8 py-2">
                            <option value="daily" {{ $period === 'daily' ? 'selected' : '' }}>Daily</option>
                            <option value="weekly" {{ $period === 'weekly' ? 'selected' : '' }}>Weekly</option>
                            <option value="monthly" {{ $period === 'monthly' ? 'selected' : '' }}>Monthly</option>
                            <option value="yearly" {{ $period === 'yearly' ? 'selected' : '' }}>Yearly</option>
                        </select>
                    </div>
                    <div>
                        <x-input-label value="Date" />
                        <x-text-input type="date" name="date" value="{{ request('date', now()->toDateString()) }}" />
                    </div>
                    <x-primary-button>View</x-primary-button>
                </form>

                <p class="text-sm text-gray-500 mb-6 font-mono">
                    Showing: {{ $start->format('M d, Y') }} @if($period !== 'daily') – {{ $end->format('M d, Y') }} @endif
                </p>

                <h3 class="font-serif text-lg text-ink mb-3">Financial summary</h3>
                <table class="w-full text-left border-collapse mb-8">
                    <tbody>
                        <tr class="border-b border-hairline"><td class="py-2 text-ink">Revenue</td><td class="py-2 text-right font-mono">{{ number_format($revenue, 2) }}</td></tr>
                        <tr class="border-b border-hairline"><td class="py-2 text-ink">Cost of goods sold (COGS)</td><td class="py-2 text-right font-mono text-negative">−{{ number_format($cogs, 2) }}</td></tr>
                        <tr class="border-b border-hairline font-medium"><td class="py-2 text-ink">Gross profit</td><td class="py-2 text-right font-mono">{{ number_format($grossProfit, 2) }}</td></tr>
                        <tr class="border-b border-hairline"><td class="py-2 text-ink">Expenses</td><td class="py-2 text-right font-mono text-negative">−{{ number_format($totalExpenses, 2) }}</td></tr>
                        <tr class="border-b border-hairline font-semibold text-base {{ $netProfit >= 0 ? 'text-positive' : 'text-negative' }}">
                            <td class="py-2">Net profit</td><td class="py-2 text-right font-mono">{{ number_format($netProfit, 2) }}</td>
                        </tr>
                    </tbody>
                </table>

                <p class="text-sm text-gray-500 mb-8">
                    Restocking spend this period (informational only, already reflected in COGS above): <span class="font-mono">{{ number_format($restockSpend, 2) }}</span>
                </p>

                <div class="grid grid-cols-2 gap-8 mb-8">
                    <div>
                        <h3 class="font-serif text-lg text-ink mb-3">Best sellers</h3>
                        <table class="w-full text-left border-collapse">
                            <thead><tr class="border-b border-hairline text-xs uppercase tracking-widest text-gray-500"><th class="py-2">Product</th><th class="py-2">Qty sold</th></tr></thead>
                            <tbody>
                                @forelse($bestSellers as $name => $qty)
                                    <tr class="border-b border-hairline"><td class="py-2 text-ink">{{ $name }}</td><td class="py-2 font-mono">{{ $qty }}</td></tr>
                                @empty
                                    <tr><td colspan="2" class="py-2 text-gray-500">No sales this period.</td></tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                    <div>
                        <h3 class="font-serif text-lg text-ink mb-3">Worst sellers</h3>
                        <table class="w-full text-left border-collapse">
                            <thead><tr class="border-b border-hairline text-xs uppercase tracking-widest text-gray-500"><th class="py-2">Product</th><th class="py-2">Qty sold</th></tr></thead>
                            <tbody>
                                @forelse($worstSellers as $name => $qty)
                                    <tr class="border-b border-hairline"><td class="py-2 text-ink">{{ $name }}</td><td class="py-2 font-mono">{{ $qty }}</td></tr>
                                @empty
                                    <tr><td colspan="2" class="py-2 text-gray-500">No sales this period.</td></tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>

                <h3 class="font-serif text-lg text-ink mb-3">Expenses by category</h3>
                <table class="w-full text-left border-collapse">
                    <thead><tr class="border-b border-hairline text-xs uppercase tracking-widest text-gray-500"><th class="py-2">Category</th><th class="py-2">Total</th></tr></thead>
                    <tbody>
                        @forelse($expensesByCategory as $category => $amount)
                            <tr class="border-b border-hairline"><td class="py-2 text-ink">{{ $category }}</td><td class="py-2 font-mono text-negative">{{ number_format($amount, 2) }}</td></tr>
                        @empty
                            <tr><td colspan="2" class="py-2 text-gray-500">No expenses this period.</td></tr>
                        @endforelse
                    </tbody>
                </table>

            </div>
        </div>
    </div>
</x-app-layout>
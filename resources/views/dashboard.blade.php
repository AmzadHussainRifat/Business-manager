<x-app-layout>
    <x-slot name="header">
        <h2 class="font-serif text-2xl text-ink leading-tight">Dashboard</h2>
    </x-slot>
    <div class="py-12">
        <div class="max-w-5xl mx-auto sm:px-6 lg:px-8">

            @if($negativeStockProducts->isNotEmpty())
                <div class="mb-6 p-4 bg-white border border-negative rounded-lg" role="alert">
                    <p class="font-semibold text-negative mb-2">Stock discrepancy detected</p>
                    <p class="text-sm text-ink mb-3">These products have negative recorded stock — likely a shipment wasn't logged in time. Sales are still being tracked accurately, but log the missing shipment to resolve this.</p>
                    <ul class="text-sm text-negative space-y-1 font-mono">
                        @foreach($negativeStockProducts as $product)
                            <li>{{ $product->name }}: {{ $product->quantity }} units</li>
                        @endforeach
                    </ul>
                    <a href="{{ route('stock.create') }}" class="inline-block mt-3 text-sm font-medium text-negative hover:underline">Log a stock movement &rarr;</a>
                </div>
            @endif

            <p class="text-gray-600 mb-6">Welcome, {{ auth()->user()->name }} ({{ ucfirst(auth()->user()->role) }})</p>

            <!-- Ledger stat tiles -->
            <div class="grid grid-cols-2 md:grid-cols-4 gap-4 mb-8">
                <div class="bg-white border border-hairline rounded-lg p-4">
                    <p class="text-xs uppercase tracking-widest text-gray-500 mb-1">Active products</p>
                    <p class="font-mono text-2xl text-ink">{{ $stats['products'] }}</p>
                </div>
                <div class="bg-white border border-hairline rounded-lg p-4">
                    <p class="text-xs uppercase tracking-widest text-gray-500 mb-1">Customers</p>
                    <p class="font-mono text-2xl text-ink">{{ $stats['customers'] }}</p>
                </div>
                <div class="bg-white border border-hairline rounded-lg p-4">
                    <p class="text-xs uppercase tracking-widest text-gray-500 mb-1">Today's sales</p>
                    <p class="font-mono text-2xl text-positive">£{{ number_format($stats['todaySales'], 2) }}</p>
                </div>
                <div class="bg-white border border-hairline rounded-lg p-4">
                    <p class="text-xs uppercase tracking-widest text-gray-500 mb-1">Today's expenses</p>
                    <p class="font-mono text-2xl text-negative">£{{ number_format($stats['todayExpenses'], 2) }}</p>
                </div>
            </div>

            <!-- Module shortcuts -->
            <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-4">
                <a href="{{ route('products.index') }}" class="block bg-white border border-hairline p-6 rounded-lg hover:border-ledger transition">
                    <h3 class="font-semibold text-lg text-ink mb-1">Products</h3>
                    <p class="text-sm text-gray-500">View and manage your product catalog</p>
                </a>
                <a href="{{ route('customers.index') }}" class="block bg-white border border-hairline p-6 rounded-lg hover:border-ledger transition">
                    <h3 class="font-semibold text-lg text-ink mb-1">Customers</h3>
                    <p class="text-sm text-gray-500">Manage customer records</p>
                </a>
                <a href="{{ route('stock.index') }}" class="block bg-white border border-hairline p-6 rounded-lg hover:border-ledger transition">
                    <h3 class="font-semibold text-lg text-ink mb-1">Stock</h3>
                    <p class="text-sm text-gray-500">Log shipments and view stock levels</p>
                </a>
                <a href="{{ route('sales.index') }}" class="block bg-white border border-hairline p-6 rounded-lg hover:border-ledger transition">
                    <h3 class="font-semibold text-lg text-ink mb-1">Sales</h3>
                    <p class="text-sm text-gray-500">Record a sale and view sales history</p>
                </a>
                <a href="{{ route('expenses.index') }}" class="block bg-white border border-hairline p-6 rounded-lg hover:border-ledger transition">
                    <h3 class="font-semibold text-lg text-ink mb-1">Expenses</h3>
                    <p class="text-sm text-gray-500">Log and track business expenses</p>
                </a>
                <a href="{{ route('reports.index') }}" class="block bg-white border border-hairline p-6 rounded-lg hover:border-ledger transition">
    <h3 class="font-semibold text-lg text-ink mb-1">Reports</h3>
    <p class="text-sm text-gray-500">Daily & weekly sales, profit, and performance</p>
</a>
<a href="{{ route('settings.index') }}" class="block bg-white border border-hairline p-6 rounded-lg hover:border-ledger transition">
    <h3 class="font-semibold text-lg text-ink mb-1">Settings</h3>
    <p class="text-sm text-gray-500">Manage user accounts and access</p>
</a>
            </div>

        </div>
    </div>
</x-app-layout>
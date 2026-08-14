<x-app-layout>
    <x-slot name="header"><h2 class="font-serif text-2xl text-ink leading-tight">Customers</h2></x-slot>
    <div class="py-12">
        <div class="max-w-6xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white border border-hairline overflow-hidden shadow-sm sm:rounded-lg p-6">
                @if(session('success'))
                    <div class="mb-4 p-3 bg-paper border border-positive text-positive rounded-lg">{{ session('success') }}</div>
                @endif

                <a href="{{ route('customers.create') }}" class="inline-block mb-4 px-4 py-2 bg-ledger text-paper rounded-md hover:bg-ink transition">Add customer</a>

                <table class="w-full text-left border-collapse">
                    <thead>
                        <tr class="border-b border-hairline text-xs uppercase tracking-widest text-gray-500">
                            <th class="py-2">Name</th>
                            <th class="py-2">Phone</th>
                            <th class="py-2">Email</th>
                            <th class="py-2">Orders</th>
                            <th class="py-2">Total spent</th>
                            <th class="py-2">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($customers as $customer)
                            <tr class="border-b border-hairline">
                                <td class="py-2">
                                    <a href="{{ route('customers.show', $customer) }}" class="text-ledger hover:underline">{{ $customer->name }}</a>
                                </td>
                                <td class="py-2 font-mono text-sm">{{ $customer->phone ?? '—' }}</td>
                                <td class="py-2 text-gray-500">{{ $customer->email ?? '—' }}</td>
                                <td class="py-2 font-mono">{{ $customer->sales_count }}</td>
                                <td class="py-2 font-mono">{{ number_format($customer->sales_sum_total_amount ?? 0, 2) }}</td>
                                <td class="py-2">
                                    <a href="{{ route('customers.edit', $customer) }}" class="text-ledger hover:underline">Edit</a>
                                    <form action="{{ route('customers.destroy', $customer) }}" method="POST" class="inline" onsubmit="return confirm('Delete this customer?');">
                                        @csrf @method('DELETE')
                                        <button type="submit" class="text-negative hover:underline ml-2">Delete</button>
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <tr><td colspan="6" class="py-4 text-center text-gray-500">No customers yet.</td></tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</x-app-layout>
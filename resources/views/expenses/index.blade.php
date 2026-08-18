<x-app-layout>
    <x-slot name="header"><h2 class="font-serif text-2xl text-ink leading-tight">Expenses</h2></x-slot>
    <div class="py-12">
        <div class="max-w-6xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white border border-hairline overflow-hidden shadow-sm sm:rounded-lg p-6">
                @if(session('success'))
                    <div class="mb-4 p-3 bg-paper border border-positive text-positive rounded-lg">{{ session('success') }}</div>
                @endif
                @if(auth()->user()->canManage('expenses'))
                    <a href="{{ route('expenses.create') }}" class="inline-block mb-4 px-4 py-2 bg-ledger text-paper rounded-md hover:bg-ink transition">Add expense</a>
                @endif
                <table class="w-full text-left border-collapse">
                    <thead>
                        <tr class="border-b border-hairline text-xs uppercase tracking-widest text-gray-500">
                            <th class="py-2">Date</th>
                            <th class="py-2">Category</th>
                            <th class="py-2">Amount</th>
                            <th class="py-2">Description</th>
                            <th class="py-2">Receipt</th>
                            <th class="py-2">Logged by</th>
                            @if(auth()->user()->canManage('expenses'))<th class="py-2">Actions</th>@endif
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($expenses as $expense)
                            <tr class="border-b border-hairline">
                                <td class="py-2 font-mono text-sm">{{ $expense->date->format('Y-m-d') }}</td>
                                <td class="py-2 text-ink">{{ $expense->category }}</td>
                                <td class="py-2 font-mono text-negative">{{ number_format($expense->amount, 2) }}</td>
                                <td class="py-2 text-gray-500">{{ $expense->description ?? '—' }}</td>
                                <td class="py-2">
                                    @if($expense->receipt_path)
                                        <div class="inline-flex items-center gap-1.5 bg-paper border border-hairline rounded-full pl-2 pr-1 py-1">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="w-3.5 h-3.5 text-gray-500" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                                <path stroke-linecap="round" stroke-linejoin="round" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                                            </svg>
                                            <a href="{{ asset('storage/' . $expense->receipt_path) }}" target="_blank" class="text-xs text-ledger hover:underline">View</a>
                                            <span class="text-gray-300">·</span>
                                            <a href="{{ asset('storage/' . $expense->receipt_path) }}" download class="text-xs text-ledger hover:underline pr-1">Download</a>
                                        </div>
                                    @else
                                        <span class="text-gray-400 text-sm">—</span>
                                    @endif
                                </td>
                                <td class="py-2">{{ $expense->user->name }}</td>
                                @if(auth()->user()->canManage('expenses'))
                                    <td class="py-2">
                                        <a href="{{ route('expenses.edit', $expense) }}" class="text-ledger hover:underline">Edit</a>
                                        <form action="{{ route('expenses.destroy', $expense) }}" method="POST" class="inline" onsubmit="return confirm('Delete this expense?');">
                                            @csrf @method('DELETE')
                                            <button type="submit" class="text-negative hover:underline ml-2">Delete</button>
                                        </form>
                                    </td>
                                @endif
                            </tr>
                        @empty
                            <tr><td colspan="7" class="py-4 text-center text-gray-500">No expenses yet.</td></tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</x-app-layout>
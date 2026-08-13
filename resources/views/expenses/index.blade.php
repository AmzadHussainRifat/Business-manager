<x-app-layout>
    <x-slot name="header"><h2 class="font-semibold text-xl text-gray-800 leading-tight">Expenses</h2></x-slot>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                @if(session('success'))
                    <div class="mb-4 p-3 bg-green-100 text-green-800 rounded">{{ session('success') }}</div>
                @endif
                @if(auth()->user()->canManage('expenses'))
                    <a href="{{ route('expenses.create') }}" class="inline-block mb-4 px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-700">Add Expense</a>
                @endif
                <table class="w-full text-left border-collapse">
                    <thead>
                        <tr class="border-b">
                            <th class="py-2">Date</th>
                            <th class="py-2">Category</th>
                            <th class="py-2">Amount</th>
                            <th class="py-2">Description</th>
                            <th class="py-2">Logged by</th>
                            @if(auth()->user()->canManage('expenses'))<th class="py-2">Actions</th>@endif
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($expenses as $expense)
                            <tr class="border-b">
                                <td class="py-2">{{ $expense->date->format('Y-m-d') }}</td>
                                <td class="py-2">{{ $expense->category }}</td>
                                <td class="py-2">{{ number_format($expense->amount, 2) }}</td>
                                <td class="py-2">{{ $expense->description ?? '—' }}</td>
                                <td class="py-2">{{ $expense->user->name }}</td>
                                @if(auth()->user()->canManage('expenses'))
                                    <td class="py-2">
                                        <a href="{{ route('expenses.edit', $expense) }}" class="text-blue-600 hover:underline">Edit</a>
                                        <form action="{{ route('expenses.destroy', $expense) }}" method="POST" class="inline" onsubmit="return confirm('Delete this expense?');">
                                            @csrf @method('DELETE')
                                            <button type="submit" class="text-red-600 hover:underline ml-2">Delete</button>
                                        </form>
                                    </td>
                                @endif
                            </tr>
                        @empty
                            <tr><td colspan="6" class="py-4 text-center text-gray-500">No expenses yet.</td></tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</x-app-layout>
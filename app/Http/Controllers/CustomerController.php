<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use Illuminate\Http\Request;

class CustomerController extends Controller
{
    public function index()
    {
        $customers = Customer::withCount('sales')
            ->withSum('sales', 'total_amount')
            ->latest()
            ->get();

        return view('customers.index', compact('customers'));
    }

    public function show(Customer $customer)
    {
        $customer->load(['sales' => fn ($q) => $q->with('items')->latest()]);

        $totalSpent = $customer->sales->sum('total_amount');
        $orderCount = $customer->sales->count();
        $avgOrderValue = $orderCount > 0 ? $totalSpent / $orderCount : 0;
        $firstOrder = $customer->sales->sortBy('created_at')->first();
        $lastOrder = $customer->sales->sortByDesc('created_at')->first();

        $favoriteItem = $customer->sales
            ->flatMap(fn ($sale) => $sale->items)
            ->groupBy('product_name')
            ->map(fn ($items) => $items->sum('quantity'))
            ->sortDesc()
            ->keys()
            ->first();

        return view('customers.show', compact(
            'customer', 'totalSpent', 'orderCount', 'avgOrderValue', 'firstOrder', 'lastOrder', 'favoriteItem'
        ));
    }

    public function create()
    {
        return view('customers.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'phone' => 'nullable|string|max:20',
            'email' => 'nullable|email|max:255',
        ]);

        Customer::create($validated);

        return redirect()->route('customers.index')->with('success', 'Customer added.');
    }

    public function edit(Customer $customer)
    {
        return view('customers.edit', compact('customer'));
    }

    public function update(Request $request, Customer $customer)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'phone' => 'nullable|string|max:20',
            'email' => 'nullable|email|max:255',
        ]);

        $customer->update($validated);

        return redirect()->route('customers.index')->with('success', 'Customer updated.');
    }

    public function destroy(Customer $customer)
    {
        $customer->delete();
        return redirect()->route('customers.index')->with('success', 'Customer deleted.');
    }
}
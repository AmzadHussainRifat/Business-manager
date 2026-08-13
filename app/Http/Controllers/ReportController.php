<?php

namespace App\Http\Controllers;

use App\Models\Sale;
use App\Models\Expense;
use App\Models\StockMovement;
use Carbon\Carbon;
use Illuminate\Http\Request;

class ReportController extends Controller
{
    public function index(Request $request)
    {
        $period = $request->get('period', 'daily');
        $dateInput = $request->get('date', now()->toDateString());

        if ($period === 'weekly') {
            $start = Carbon::parse($dateInput)->startOfWeek();
            $end = Carbon::parse($dateInput)->endOfWeek();
        } else {
            $start = Carbon::parse($dateInput)->startOfDay();
            $end = Carbon::parse($dateInput)->endOfDay();
        }

        $sales = Sale::with('items')->whereBetween('created_at', [$start, $end])->get();
        $expenses = Expense::whereBetween('date', [$start->toDateString(), $end->toDateString()])->get();
        $stockIn = StockMovement::where('type', 'in')->whereBetween('date', [$start->toDateString(), $end->toDateString()])->get();

        $revenue = $sales->sum('total_amount');
        $cogs = $sales->flatMap->items->sum('total_cost');
        $grossProfit = $revenue - $cogs;
        $totalExpenses = $expenses->sum('amount');
        $netProfit = $grossProfit - $totalExpenses;
        $restockSpend = $stockIn->sum(fn($m) => $m->quantity * $m->unit_cost);

        $productSales = $sales->flatMap->items
            ->groupBy('product_name')
            ->map(fn($items) => $items->sum('quantity'))
            ->sortDesc();

        $bestSellers = $productSales->take(5);
        $worstSellers = $productSales->sort()->take(5);

        $expensesByCategory = $expenses->groupBy('category')->map(fn($e) => $e->sum('amount'));

        return view('reports.index', compact(
            'period', 'start', 'end', 'revenue', 'cogs', 'grossProfit',
            'totalExpenses', 'netProfit', 'restockSpend',
            'bestSellers', 'worstSellers', 'expensesByCategory'
        ));
    }
}
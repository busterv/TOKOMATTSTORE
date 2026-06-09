<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Models\Transaction;
use App\Models\Menu;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller {
    public function index() {
        $today = now()->toDateString();
        $stats = [
            'revenue' => Transaction::whereDate('transaction_date', $today)->sum('total_price') ?? 0,
            'sold' => DB::table('transaction_details')->join('transactions', 'transaction_details.transaction_id', '=', 'transactions.id')->whereDate('transactions.transaction_date', $today)->sum('transaction_details.quantity') ?? 0,
            'stock' => Menu::sum('stock') ?? 0,
            'txns' => Transaction::whereDate('transaction_date', $today)->count() ?? 0,
        ];

        $chartLabels = []; $chartData = [];
        for ($i = 5; $i >= 0; $i--) {
            $date = now()->subMonths($i);
            $chartLabels[] = $date->format('M Y');
            $chartData[] = Transaction::whereYear('transaction_date', $date->year)->whereMonth('transaction_date', $date->month)->sum('total_price') ?? 0;
        }
        $recentTransactions = Transaction::with('user')->latest()->take(5)->get();
        return view('dashboard.index', compact('stats', 'chartLabels', 'chartData', 'recentTransactions'));
    }

    public function showDetail($id) {
        $transaction = Transaction::with('details.menu')->findOrFail($id);
        return response()->json($transaction);
    }
}

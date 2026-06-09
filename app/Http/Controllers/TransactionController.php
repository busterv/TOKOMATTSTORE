<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Models\Transaction;
use App\Models\TransactionDetail;
use App\Models\Menu;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class TransactionController extends Controller {
    public function pos() {
        $menus = Menu::with('category')->where('stock', '>', 0)->get();
        return view('transactions.pos', compact('menus'));
    }

   public function store(Request $request)
{
    // Validasi input
    $validated = $request->validate([
        'items' => 'required|array|min:1',
        'items.*.menu_id' => 'required|exists:menu,id',
        'items.*.quantity' => 'required|integer|min:1',
        'items.*.price' => 'required|numeric|min:0',
        'total_price' => 'required|numeric|min:0',
        'total_paid' => 'required|numeric|min:0',
        'total_return' => 'required|numeric|min:0',
    ]);

    DB::beginTransaction();
    
    try {
        // Generate kode transaksi unik
        $trxCode = 'TRX-HP-' . now()->format('Ymd') . '-' . strtoupper(substr(uniqid(), -4));
        
        // Simpan header transaksi
        $transaction = Transaction::create([
            'user_id' => Auth::id(),
            'transaction_code' => $trxCode,
            'total_price' => $validated['total_price'],
            'total_paid' => $validated['total_paid'],
            'total_return' => $validated['total_return'],
            'transaction_date' => now(),
        ]);

        // Proses setiap item
        foreach ($validated['items'] as $item) {
            // Lock row untuk mencegah race condition
            $menu = Menu::lockForUpdate()->findOrFail($item['menu_id']);
            
            // Validasi stok di server
            if ($menu->stock < $item['quantity']) {
                throw new \Exception("Stok {$menu->item_name} tidak mencukupi. Sisa: {$menu->stock}");
            }

            // Simpan detail
            TransactionDetail::create([
                'transaction_id' => $transaction->id,
                'menu_id' => $item['menu_id'],
                'quantity' => $item['quantity'],
                'price_at_transaction' => $item['price'],
                'subtotal' => $item['quantity'] * $item['price'],
            ]);

            // Kurangi stok
            $menu->decrement('stock', $item['quantity']);
        }

        DB::commit();
        
        return response()->json([
            'success' => true,
            'message' => 'Transaksi berhasil',
            'trx_id' => $transaction->id,
            'code' => $transaction->transaction_code
        ]);
        
    } catch (\Exception $e) {
        DB::rollBack();
        
        return response()->json([
            'success' => false,
            'message' => $e->getMessage()
        ], 400);
    }
}

    public function print($id) {
        $transaction = Transaction::with(['details.menu', 'user'])->findOrFail($id);
        return view('transactions.print', compact('transaction'));
    }
}
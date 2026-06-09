<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Model;
class Transaction extends Model {
    protected $fillable = ['user_id', 'transaction_code', 'total_price', 'total_paid', 'total_return', 'transaction_date'];
    protected $casts = ['total_price' => 'decimal:2', 'total_paid' => 'decimal:2', 'total_return' => 'decimal:2', 'transaction_date' => 'datetime'];
    public function user() { return $this->belongsTo(User::class); }
    public function details() { return $this->hasMany(TransactionDetail::class)->with('menu'); }
}

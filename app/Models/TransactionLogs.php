<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TransactionLogs extends Model
{
    use HasFactory;

    protected $table = 'transaction_logs';

    protected $fillable = ['name', 'transaction_id', 'product_id', 'qty', 'price', 'total_price'];


    public function transactionLogs()
    {
        return $this->belongsTo(Transactions::class, 'transaction_id');
    }

    public function product()
    {
        return $this->belongsTo(Product::class, 'product_id');
    }
}

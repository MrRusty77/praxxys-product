<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Transactions extends Model
{
    use HasFactory;

    protected $table = 'transactions';

    public function users()
    {
        return $this->belongsTo(Users::class);
    }

    public function transactionLogs()
    {
        return $this->hasMany(TransactionLogs::class);
    }

}

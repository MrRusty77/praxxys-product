<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;


class Transactions extends Model
{
    use HasFactory;

    use \Staudenmeir\EloquentHasManyDeep\HasRelationships;

    protected $table = 'transactions';

    public function users()
    {
        return $this->belongsTo(Users::class);
    }

    public function transactionLogs()
    {
        return $this->hasMany(TransactionLogs::class, 'transaction_id');
    }
}

        // return $this->hasManyDeep(
        //     TransactionLogs::class,
        //     [Images::class, Product::class,], // Intermediate models, beginning at the far parent (Country).
        //     [
        //         'id', // Foreign key on the "users" table.
        //         'id',    // Foreign key on the "posts" table.
        //         'product_id'     // Foreign key on the "comments" table.
        //     ],
        //     [
        //         'id', // Local key on the "countries" table.
        //         'id', // Local key on the "users" table.
        //         'id'  // Local key on the "posts" table.
        //     ]
        // );

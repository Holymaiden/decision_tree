<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TransactionDetail extends Model
{
    use HasFactory;
    protected $table = 'transaction_details';
    protected $fillable = [
        'transaction_id',
        'drug_id',
        'quantity',
        'price'
    ];

    public function obat()
    {
        return $this->hasOne('App\Models\Drug', 'id', 'drug_id');
    }
}

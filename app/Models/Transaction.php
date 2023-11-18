<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Transaction extends Model
{
    use HasFactory;
    // protected $table = 'role';
    protected $fillable = [
        'name',
        'total_price',
        'date',
        'tunai',
        'pdf'
    ];

    public function detail()
    {
        return $this->hasMany('App\Models\TransactionDetail', 'transaction_id', 'id')->with('obat');
    }
}

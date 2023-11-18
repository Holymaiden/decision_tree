<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Cart extends Model
{
    use HasFactory;
    protected $fillable = [
        'drug_id',
        'total',
    ];

    public function detail()
    {
        return $this->hasOne('App\Models\Drug', 'id', 'drug_id');
    }
}

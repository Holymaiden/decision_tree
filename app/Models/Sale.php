<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Sale extends Model
{
    use HasFactory;
    // protected $table = 'role';
    protected $fillable = [
        'drug_id',
        'total_sale',
        'date',
    ];

    public function detail()
    {
        return $this->hasOne('App\Models\Drug', 'id', 'drug_id');
    }
}

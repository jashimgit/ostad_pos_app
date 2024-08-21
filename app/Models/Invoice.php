<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Invoice extends Model
{
    use HasFactory;

    protected $fillable = [
        'total',
        'vat',
        'discount',
        'payable',
        'user_id',
        'customer_id'
    ];



    function customer() {
        return $this->belongsTo(Customer::class);
    }
}

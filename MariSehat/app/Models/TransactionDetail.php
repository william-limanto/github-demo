<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TransactionDetail extends Model
{
    use HasFactory;
    public $timestamps = false;

    public function TransactionHistory(){
        return $this->belongsTo(TransactionHistory::class);
    }
}

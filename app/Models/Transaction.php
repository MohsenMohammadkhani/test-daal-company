<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Transaction extends Model
{
    use HasFactory;

    protected $table = "transactions";
    public $timestamps = false;
    protected $fillable = [
        'user_id',
        'balance_now',
        'balance_before',
        'amount',
        'created_at',
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'id');
    }

}

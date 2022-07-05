<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'order_id',
        'method',
        'bank',
        'paid_at'
    ];

    /**
     * Validation Rules
     *
     * @var array
     */
    public static $rules = [
        'order_id'  => 'required|exists:orders,id|unique:payments,order_id',
        'method'    => 'required|between:0,3',
        'bank'      => 'required_if:method,2',
    ];

    /**
     * Get the order that owns the paymment.
     */
    public function order()
    {
        return $this->belongsTo(Order::class);
    }

    /**
     * Get the status name of the method.
     */
    public function getMethodNameAttribute()
    {
        $methods = [
            'Cash',
            'Debit/Credit',
            'Online Banking',
            'eWallet'
        ];

        //TODO: Add more banks
        $banks = [
            'Maybank2U'
        ];

        if ($this->method == 2)
            return $methods[$this->method] . ' - ' . $banks[$this->bank];

        return $methods[$this->method];
    }
}
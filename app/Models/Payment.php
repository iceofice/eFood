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
        'paid_at',
        'discount_id'
    ];

    /**
     * Validation Rules
     *
     * @var array
     */
    public static $rules = [
        'order_id'      => 'required|exists:orders,id|unique:payments,order_id',
        'discount_id'   => 'nullable|exists:discounts,id',
        'method'        => 'required|between:0,3',
        'bank'          => 'required_if:method,2',
    ];

    /**
     * Get the order that owns the paymment.
     */
    public function order()
    {
        return $this->belongsTo(Order::class);
    }

    /**
     * Get the discount that owns the paymment.
     */
    public function discount()
    {
        return $this->belongsTo(Discount::class);
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

    //TODO: Docs
    public function getDiscountTotalAttribute()
    {
        if ($this->discount_id)
            return $this->order->total * (100 - $this->discount->amount) / 100;
        return $this->order->total;
    }
}

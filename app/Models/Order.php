<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'total',
        'status',
        'customer_id',
    ];

    /**
     * Validation Rules
     *
     * @var array
     */
    public static $rules = [
        'status'        => 'required|integer|between:0,5',
        'customer_id'   => 'required|exists:customers,id',
    ];

    /**
     * The menus that belongs to the order.
     * 
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function menus()
    {
        return $this->belongsToMany(Menu::class)
            ->using(MenuOrder::class)
            ->withPivot('qty', 'price')
            ->withTimestamps();
    }

    /**
     * Get the customer that owns the order.
     */
    public function customer()
    {
        return $this->belongsTo(Customer::class);
    }

    /**
     * Get the status name of the order.
     */
    public function getStatusNameAttribute()
    {
        $statuses = [
            0 => 'Pending',
            1 => 'Recieved By Kitchen',
            2 => 'Cooking',
            3 => 'Ready',
            4 => 'Delivered',
            5 => 'Completed',
        ];

        return $statuses[$this->status];
    }

    /**
     * Get the customer name of the order.
     */
    public function getCustomerNameAttribute()
    {
        return $this->customer->name;
    }
}

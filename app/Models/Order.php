<?php

namespace App\Models;

use Carbon\Carbon;
use App\Notifications\OrderCreated;
use App\Notifications\OrderUpdated;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Notification;
use Illuminate\Database\Eloquent\Factories\HasFactory;

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
        'reserved_at',
        'customer_id',
        'table_id',
        'user_id'
    ];

    /**
     * Validation Rules
     *
     * @var array
     */
    public static $rules = [
        'status'        => 'required|integer|between:0,5',
        'reserved_at'   => 'required|date',
        'customer_id'   => 'required|exists:customers,id',
        'table_id'      => 'required|exists:tables,id',
        'user_id'       => 'exists:users,id',
    ];

    public static function boot()
    {
        parent::boot();

        static::created(function ($order) {
            if (is_null($order->user_id)) {
                $waiters = User::role('Waiter')->get();
                Notification::send($waiters, new OrderCreated($order->id));
            } else {
                $order->user->notify(new OrderCreated($order->id));
            }

            $kitchenStaff = User::role('Kitchen Staff')->get();
            Notification::send($kitchenStaff, new OrderCreated($order->id));
        });

        static::updated(function ($order) {
            $order->user->notify(new OrderUpdated($order->id));
        });
    }

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
     * Get the customer that owns the order.
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get the table that owns the order.
     */
    public function table()
    {
        return $this->belongsTo(Table::class);
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

    /**
     * Get the waiter name of the order.
     */
    public function getWaiterNameAttribute()
    {
        return $this->user->name;
    }

    /**
     * Get the hour of the order.
     */
    public function getTimeAttribute()
    {
        return Carbon::parse($this->reserved_at)->format('G:i');
    }

    /**
     * Get the date of the order.
     */
    public function getDateAttribute()
    {
        return Carbon::parse($this->reserved_at)->format('m/d/Y');
    }
}

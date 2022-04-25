<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Customer extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'phone',
        'password',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Validation Rules
     *
     * @var array
     */
    public static $rules = [
        'name'      => 'required',
        'email'     => 'required_without:phone|nullable|email|unique:customers,email',
        'phone'     => 'required_without:email|nullable|numeric',
        'password'  => 'nullable|confirmed',
    ];

    /**
     * Get the orders for the customer.
     */
    public function orders()
    {
        return $this->hasMany(Order::class);
    }

    //TODO: Custom messages for required_without validation rule
}

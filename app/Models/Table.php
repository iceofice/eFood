<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Table extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'min',
        'max'
    ];

    /**
     * Validation Rules
     *
     * @var array
     */
    public static $rules = [
        'name'      => 'required',
        'min'       => 'required|integer',
        'max'       => 'required|integer',
    ];

    /**
     * Get the orders for the table.
     */
    public function orders()
    {
        return $this->hasMany(Order::class);
    }
}

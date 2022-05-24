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
        'qty',
    ];

    /**
     * Validation Rules
     *
     * @var array
     */
    public static $rules = [
        'name'      => 'required',
        'qty'       => 'required|integer',

    ];
}

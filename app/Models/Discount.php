<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Discount extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'title',
        'subtitle',
        'amount',
        'start_date',
        'end_date',
    ];

    /**
     * Validation Rules
     *
     * @var array
     */
    public static $rules = [
        'title'         => 'required',
        'subtitle'      => 'required',
        'amount'        => 'required|numeric|min:1|max:100',
        'start_date'    => 'required|date',
        'end_date'      => 'required|date',
    ];

    /**
     * The payments that belongs to the discount.
     * 
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function payments()
    {
        return $this->hasMany(Payment::class);
    }
}

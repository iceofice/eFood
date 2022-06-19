<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Attendance extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'clock_in',
        'clock_out',
        'user_id',
    ];

    /**
     * Validation Rules
     *
     * @var array
     */
    public static $rules = [
        'clock_in'  => 'required|date',
        'clock_out' => 'required|date',
        'user_id'   => 'required|exists:users,id',
    ];

    /**
     * Get the customer that owns the attendance.
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}

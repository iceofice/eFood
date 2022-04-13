<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Cviebrock\EloquentSluggable\Sluggable;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Category extends Model
{
    use HasFactory, Sluggable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'slug',
        'description',
        'image',
        'type'
    ];

    /**
     * Validation Rules
     *
     * @var array
     */
    public static $rules = [
        'name'          => 'required',
        'slug'          => 'required|alpha_dash|unique:categories,slug',
        'description'   => '',
        'image'         => 'image',
        'type'          => 'required|numeric',
    ];

    /**
     * The attributes that can be converted to slug.
     *
     * @return array
     */
    public function sluggable()
    {
        return [
            'slug' => [
                'source' => 'name'
            ]
        ];
    }
}

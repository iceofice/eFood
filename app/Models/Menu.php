<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Cviebrock\EloquentSluggable\Sluggable;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Menu extends Model
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
        'price',
        'featured',
    ];

    /**
     * Validation Rules
     *
     * @var array
     */
    public static $rules = [
        'name'          => 'required',
        'slug'          => 'required|alpha_dash|unique:menus,slug',
        'description'   => '',
        'image'         => 'image',
        'price'         => 'required|numeric',
        'categories'    => 'array',
        'categories.*'  => 'exists:categories,id',
        'featured'      => 'boolean',
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

    /**
     * The categories that belongs to the menu.
     * 
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function categories()
    {
        return $this->belongsToMany(Category::class);
    }

    /**
     * The orders that belongs to the menu.
     * 
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function orders()
    {
        return $this->belongsToMany(Order::class)
            ->using(MenuOrder::class)
            ->withPivot('qty', 'price', 'note')
            ->withTimestamps();
    }

    /**
     * Array of categories ids.
     *
     * @return array<int, int>
     */
    public function getCategoryIdListAttribute()
    {
        return $this->categories->pluck('id')->toArray();
    }

    /**
     * Array of categories names.
     *
     * @return array<int, String>
     */
    public function getCategoryNameListAttribute()
    {
        return $this->categories->pluck('name')->toArray();
    }
}

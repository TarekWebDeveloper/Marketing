<?php

namespace App\Models;

use Cviebrock\EloquentSluggable\Sluggable;
use Illuminate\Database\Eloquent\Model;
use Nicolaslopezj\Searchable\SearchableTrait;

class Page extends Model
{
    use Sluggable, SearchableTrait;

    protected $table = 'products';
    protected $guarded = [];

    public function sluggable()
    {
        return [
            'slug' => [
                'source' => 'title'
            ]
        ];
    }

    protected $searchable = [
        'columns'   => [
            'products.title'       => 10,
            'products.description' => 10,
        ],
    ];

    public function category()
    {
        return $this->belongsTo(Category::class, 'category_id', 'id');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }

    public function media()
    {
        return $this->hasMany(ProductImage::class, 'product_id', 'id');
    }

    public function status()
    {
        return $this->status == 1 ? 'فعال' : 'غير فعال';
    }

}

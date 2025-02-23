<?php

namespace App\Models;
use Cviebrock\EloquentSluggable\Sluggable;

use Illuminate\Database\Eloquent\Model;
use Nicolaslopezj\Searchable\SearchableTrait;

class Product extends Model
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
   
    public function scopeEffective($query)
    {
        return $query->where('status', 1);
    }


    public function scopeProduct($query)
    {
        return $query->where('product_type', 'product');
    }




    public function category()
    {
        return $this->belongsTo(Category::class);
    }


    public function user()
    {
        return $this->belongsTo(User::class);  
     }


    public function comments()
    {
        return $this->hasMany(Comment::class);
    }

    public function active_comments()
    {
        return $this->hasMany(Comment::class)->whereStatus(1);
    }


    public function media()
    {
        return $this->hasMany(ProductImage::class);    
    }

   
    public function status()
    {
        return $this->status == 1 ? 'فعال' : 'غير فعال';
    }
    
    
    }
    
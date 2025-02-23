<?php


namespace App\Models;

use Cviebrock\EloquentSluggable\Sluggable;
use Illuminate\Database\Eloquent\Model;


class Category extends Model
{

    use Sluggable;

    protected $guarded = [];

    public function sluggable()
    {
        return [
            'slug' => [
                'source' => 'name'
            ]
        ];
    }


    public function products()
    {
        return $this->hasMany(product::class);
    }


        public function status()
        {
            return $this->status == 1 ? 'فعال' : 'غير فعال';
        }
    
    }
    
    
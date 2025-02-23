<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Nicolaslopezj\Searchable\SearchableTrait;

class Comment extends Model
{


    use SearchableTrait;

    protected $guarded = [];

    protected $searchable = [
        'columns'   => [

            'comments.name'         => 10,

            'comments.email'        => 10,
            
            'comments.comment'      => 10,
        ],
    ];

    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    public function status()
    {
        return $this->status == 1 ? 'فعال' : 'غير فعال';
    }

}

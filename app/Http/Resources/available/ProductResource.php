<?php

namespace App\Http\Resources\available;

use Illuminate\Http\Resources\Json\JsonResource;
use App\Http\Resources\available\CategoryResource;
use App\Http\Resources\available\UserResource;

class ProductResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return [


            'title' =>$this->title,
            'slug' =>$this->slug,

            'description' =>$this->description,
            'status' =>$this->status(),
            'product_type' =>$this->product_type,
            'comment_able' =>$this->comment_able,
            'user_id' =>$this->user->name,
            'category_id' =>$this->category->name,
            'category' => new CategoryResource($this->category),

            'category_id' =>$this->category->name,



        ];
    }
}

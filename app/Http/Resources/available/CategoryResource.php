<?php

namespace App\Http\Resources\available;

use Illuminate\Http\Resources\Json\JsonResource;

class CategoryResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     * 
     * 
     * 
     * 
     */
    public function toArray($request)
    {
    return [


        'name' =>$this->name,
        'slug' =>$this->slug,
    
        'status' =>$this->status(),
        'title' =>$this->title,
            'slug' =>$this->slug,

    ];     
        
    }
}
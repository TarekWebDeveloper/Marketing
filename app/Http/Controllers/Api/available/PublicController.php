<?php

namespace App\Http\Controllers\Api\available;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Product;
use   App\Http\Resources\available\ProductResource;

class PublicController extends Controller
{
    public function get_product()
    {
                         
        $products = Product::whereHas('category', function ($query) {
           $query->whereStatus(1);
        })

        ->whereHas('user', function ($query) {

            $query->whereStatus(1);
       })

        ->product()->effective()->orderBy('id', 'desc')->paginate(8);
       
if( $products->count()>0){


return ProductResource::collection($products);

}else
  {
    return response()->json(['error'=>true  ,  'message'=>'لايوجد منتج '],201);


   }}


 


}
<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Category;
use App\Models\Comment;
use App\Models\Product;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Validator;
use Intervention\Image\Facades\Image;
use Stevebauman\Purify\Facades\Purify;

class ProductCommentsController extends Controller
{
    public function __construct()
    {
        if (\auth()->check()){
            $this->middleware('auth');
        } else {
            return view('backend.auth.login');
        }
    }


    //index
    public function index()
    {
        if (!\auth()->user()->ability('admin', 'manage_product_comments,show_product_comments')) {
            return redirect('admin/index');
        }

        $keyword = (isset(\request()->keyword) && \request()->keyword != '') ? 

        \request()->keyword : null;

        $productId = (isset(\request()->product_id) && \request()->product_id != '') ? 

        \request()->product_id : null;

        $status = (isset(\request()->status) && \request()->status != '') ?

         \request()->status : null;

        $sort_by = (isset(\request()->sort_by) && \request()->sort_by != '') ? 

        \request()->sort_by : 'id';

        $order_by = (isset(\request()->order_by) && \request()->order_by != '') ?

         \request()->order_by : 'desc';

        $limit_by = (isset(\request()->limit_by) && \request()->limit_by != '') ?

         \request()->limit_by : '10';

        $comments = Comment::query();

        if ($keyword != null) {

            $comments = $comments->search($keyword);
        }

        if ($productId != null) {

            $comments = $comments->whereProductId($productId);
        }

        if ($status != null) {

            $comments = $comments->whereStatus($status);
        }

        $comments = $comments->orderBy($sort_by, $order_by);

        $comments = $comments->paginate($limit_by);

        $products = Product::whereProductType('product')->pluck('title', 'id');

        return view('backend.product_comments.index', compact('comments', 'products'));

    }

  


    //edit
    public function edit($id)
    {
        if (!\auth()->user()->ability('admin', 'update_product_comments')) {
            return redirect('admin/index');
        }

        $comment = Comment::whereId($id)->first();

        return view('backend.product_comments.edit', compact('comment'));
    }


    //update
    public function update(Request $request, $id)
    {
        if (!\auth()->user()->ability('admin', 'update_product_comments')) {
            return redirect('admin/index');
        }

        $validator = Validator::make($request->all(), [
            'name'          => 'required',

            'email'         => 'required|email',

            'url'           => 'nullable|url',

            'status'        => 'required',

            'comment'       => 'required',
        ]);

        if($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $comment = Comment::whereId($id)->first();

        if ($comment) {
            $data['name']           = $request->name;

            $data['email']          = $request->email;

            $data['url']            = $request->url;

            $data['status']         = $request->status;

            $data['comment']        = Purify::clean($request->comment);

            $comment->update($data);

            Cache::forget('recent_comments');

            return redirect()->route('admin.product_comments.index')->with([

                'message' => 'تم تحديث التعليق بنجاح',

                'alert-type' => 'success',
            ]);

        }
        return redirect()->route('admin.product_comments.index')->with([

            'message' => 'فشلت العملية',

            'alert-type' => 'danger',

        ]);
    }



    //destroy
    public function destroy($id)
    {
        if (!\auth()->user()->ability('admin', 'delete_product_comments')) {
            return redirect('admin/index');
        }

        $comment = Comment::whereId($id)->first();

        $comment->delete();

        return redirect()->route('admin.product_comments.index')->with([

            'message' => 'تم حذف التعليق بنجاح',
            
            'alert-type' => 'success',
        ]);
    }

}

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



class ProductsController extends Controller
{
    public function __construct()
    {
        if (\auth()->check()){
            $this->middleware('auth');
        } else {
            return view('backend.auth.login');
        }
    }

    public function index()

    {

        //permission

        if (!\auth()->user()->ability('admin', 'manage_products,show_products')) {
            return redirect('admin/home');
        }




        //filter

        $mykeyword = (isset(\request()->keyword) && \request()->keyword != '') ?
         \request()->keyword : null;

        $categoryId = (isset(\request()->category_id) && \request()->category_id != '') ? 
        \request()->category_id : null;

        $status = (isset(\request()->status) && \request()->status != '') ?
         \request()->status : null;

        $sort_by = (isset(\request()->sort_by) && \request()->sort_by != '') ?
         \request()->sort_by : 'id';

        $order_by = (isset(\request()->order_by) && \request()->order_by != '') ?
         \request()->order_by : 'desc';

        $limit_by = (isset(\request()->limit_by) && \request()->limit_by != '') ? 
        \request()->limit_by : '10';


        //Posts according to filtering

        $products = Product::with(['user', 'category', 'comments'])->whereProductType('product');

        if ($mykeyword != null) {
            $products = $products->search($keyword);
        }
        if ($categoryId != null) {
            $products = $products->whereCategoryId($categoryId);
        }
        if ($status != null) {
            $products = $products->whereStatus($status);
        }

        $products = $products->orderBy($sort_by, $order_by);

        $products = $products->paginate($limit_by);

        $categories = Category::orderBy('id', 'desc')->pluck('name', 'id');

        return view('backend.products.index', compact('categories', 'products'));

    }

    public function create()
    {

    //permission

        if (!\auth()->user()->ability('admin', 'create_products')) {
            return redirect('admin/index');
        }

        $categories = Category::orderBy('id', 'desc')->pluck('name', 'id');
        return view('backend.products.create', compact('categories'));
    }

    public function store(Request $request)
    {

    //permission
        if (!\auth()->user()->ability('admin', 'create_products')) {
            return redirect('admin/index');
        }

        $validator = Validator::make($request->all(), [
            'title'         => 'required',

            'description'   => 'required|min:50',

            'status'        => 'required',

            'comment_able'  => 'required',

            'category_id'   => 'required',

            'images.*'      => 'nullable|mimes:jpg,jpeg,png,gif|max:20000',
        ]);

        if($validator->fails()) {

            return redirect()->back()->withErrors($validator)->withInput();
        }

        $data['title']              = $request->title;

        $data['description']        = Purify::clean($request->description);

        $data['status']             = $request->status;

        $data['product_type']          = 'product';

        $data['comment_able']       = $request->comment_able;

        $data['category_id']        = $request->category_id;

        $product = auth()->user()->products()->create($data);

        if ($request->images && count($request->images) > 0) {
            $i = 1;
            foreach ($request->images as $file) {
                $filename = $product->slug.'-'.time().'-'.$i.'.'.$file->getClientOriginalExtension();
                $file_size = $file->getSize();
                $file_type = $file->getMimeType();
                $path = public_path('assets/image_product/' . $filename);
                Image::make($file->getRealPath())->resize(800, null, function ($constraint) {
                    $constraint->aspectRatio();
                })->save($path, 100);

                $product->media()->create([
                    'file_name' => $filename,
                    'file_size' => $file_size,
                    'file_type' => $file_type,
                ]);
                $i++;
            }
        }

        if ($request->status == 1) {
            Cache::forget('recent_products');
        }

        return redirect()->route('admin.products.index')->with([
            'message' => 'تم إنشاء المنتج بنجاح',
            'alert-type' => 'success',
        ]);
    }

    public function show($id)
    {

    //permission  

        if (!\auth()->user()->ability('admin', 'display_products')) {
            return redirect('admin/index');
        }

        $product = Product::with(['media', 'category', 'user', 'comments'])->whereId($id)->whereProductType('product')->first();
        return view('backend.products.show', compact('product'));
    }

    public function edit($id)
    {

    //permission 

        if (!\auth()->user()->ability('admin', 'update_products')) {
            return redirect('admin/index');
        }

        $categories = Category::orderBy('id', 'desc')->pluck('name', 'id');
        $product = Product::with(['media'])->whereId($id)->whereProductType('product')->first();

        return view('backend.products.edit', compact('categories', 'product'));
    }

    public function update(Request $request, $id)
    {

     //permission 

        if (!\auth()->user()->ability('admin', 'update_products')) {
            return redirect('admin/index');
        }

        $validator = Validator::make($request->all(), [

            'title'         => 'required',

            'description'   => 'required|min:50',

            'status'        => 'required',

            'comment_able'  => 'required',

            'category_id'   => 'required',

            'images.*'      => 'nullable|mimes:jpg,jpeg,png,gif|max:20000',
        ]);

        if($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $product = Product::whereId($id)->whereProductType('product')->first();

        if ($product) {

            $data['title']              = $request->title;

            $data['slug']               = null;

            $data['description']        = Purify::clean($request->description);

            $data['status']             = $request->status;

            $data['comment_able']       = $request->comment_able;

            $data['category_id']        = $request->category_id;

            $product->update($data);

            if ($request->images && count($request->images) > 0) {
                $i = 1;
                foreach ($request->images as $file) {

                    $filename = $product->slug.'-'.time().'-'.$i.'.'.$file->getClientOriginalExtension();

                    $file_size = $file->getSize();

                    $file_type = $file->getMimeType();

                    $path = public_path('assets/image_product/' . $filename);

                    Image::make($file->getRealPath())->resize(800, null, function ($constraint) {

                        $constraint->aspectRatio();

                    })->save($path, 100);

                    $product->media()->create([
                        'file_name' => $filename,
                        'file_size' => $file_size,
                        'file_type' => $file_type,
                    ]);
                    $i++;
                }
            }

            return redirect()->route('admin.products.index')->with([
                'message' => 'تم تحديث المنتج بنجاح',
                'alert-type' => 'success',
            ]);

        }
        return redirect()->route('admin.products.index')->with([
            'message' => ' فشلت العملية',
            'alert-type' => 'danger',
        ]);
    }

    public function destroy($id)
    {

     //permission 

        if (!\auth()->user()->ability('admin', 'delete_products')) {
            return redirect('admin/index');
        }

        $product = Product::whereId($id)->whereProductType('product')->first();

        if ($product) {
            if ($product->media->count() > 0) {
                foreach ($product->media as $media) {
                    if (File::exists('assets/image_product/' . $media->file_name)) {
                        unlink('assets/image_product/' . $media->file_name);
                    }
                }
            }
            $product->delete();

            return redirect()->route('admin.products.index')->with([
                'message' => 'تم حذف المنتج بنجاح',
                'alert-type' => 'success',
            ]);
        }

        return redirect()->route('admin.products.index')->with([
            'message' => ' فشلت العملية',
            'alert-type' => 'danger',
        ]);
    }


    // removeImage

    public function removeImage(Request $request)
    {

    //permission  

        if (!\auth()->user()->ability('admin', 'delete_products')) {
            return redirect('admin/index');
        }

        $media = ProductImage::whereId($request->media_id)->first();
        if ($media) {
            if (File::exists('assets/image_product/' . $media->file_name)) {
                unlink('assets/image_product/' . $media->file_name);
            }
            $media->delete();
            return true;
        }
        return false;
    }

}

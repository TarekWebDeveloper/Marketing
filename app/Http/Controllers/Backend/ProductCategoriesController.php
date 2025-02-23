<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Category;
use App\Models\Product;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Validator;
use Intervention\Image\Facades\Image;
use Stevebauman\Purify\Facades\Purify;




class ProductCategoriesController extends Controller
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
        if (!\auth()->user()->ability('admin', 'manage_product_categories,show_product_categories')) {
            return redirect('admin/index');
        }

        $keyword = (isset(\request()->keyword) && \request()->keyword != '') ?
         \request()->keyword : null;

        $status = (isset(\request()->status) && \request()->status != '') ? 
        \request()->status : null;

        $sort_by = (isset(\request()->sort_by) && \request()->sort_by != '') ? 
        \request()->sort_by : 'id';

        $order_by = (isset(\request()->order_by) && \request()->order_by != '') ?
         \request()->order_by : 'desc';

        $limit_by = (isset(\request()->limit_by) && \request()->limit_by != '') ? 
        \request()->limit_by : '10';


        $categories = Category::withCount('products');
        if ($keyword != null) {
            $categories = $categories->search($keyword);
        }

        if ($status != null) {
            $categories = $categories->whereStatus($status);
        }

        $categories = $categories->orderBy($sort_by, $order_by);
        $categories = $categories->paginate($limit_by);

        return view('backend.product_categories.home', compact('categories'));

    }

    //create

    public function create()
    {
        if (!\auth()->user()->ability('admin', 'create_product_categories')) {
            return redirect('admin/index');
        }

        return view('backend.product_categories.create');
    }




    //store

    public function store(Request $request)
    {
        if (!\auth()->user()->ability('admin', 'create_product_categories')) {
            return redirect('admin/index');
        }

        $validator = Validator::make($request->all(), [
            'name'          => 'required',
            'status'        => 'required',
        ]);
        if($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $data['name']              = $request->name;
        $data['status']             = $request->status;

        Category::create($data);

        if ($request->status == 1) {
            Cache::forget('global_categories');
        }

        return redirect()->route('admin.product_categories.index')->with([
            'message' => 'تم اضافة فئة  بنجاح',
            'alert-type' => 'success',
        ]);
    }

    public function show($id)
    {
        //
    }


    //edit
    public function edit($id)
    {
        if (!\auth()->user()->ability('admin', 'update_product_categories')) {
            return redirect('admin/index');
        }

        $category = Category::whereId($id)->first();
        return view('backend.product_categories.edit', compact('category'));
    }



    //update

    public function update(Request $request, $id)
    {
        if (!\auth()->user()->ability('admin', 'update_product_categories')) {
            return redirect('admin/index');
        }

        $validator = Validator::make($request->all(), [
            'name'          => 'required',
            'status'        => 'required',
        ]);
        if($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $category = Category::whereId($id)->first();

        if ($category) {
            $data['name']               = $request->name;
            $data['slug']               = null;
            $data['status']             = $request->status;


            $category->update($data);

            Cache::forget('global_categories');

            return redirect()->route('admin.product_categories.index')->with([

                'message' => 'تم تحديث الفئة بنجاح',

                'alert-type' => 'success',
            ]);

        }
        return redirect()->route('admin.product_categories.index')->with([

            'message' => 'فشلت العملية',

            'alert-type' => 'danger',
        ]);
    }


    //destroy

    public function destroy($id)
    {
        if (!\auth()->user()->ability('admin', 'delete_product_categories')) {
            return redirect('admin/index');
        }

        $category = Category::whereId($id)->first();

        foreach ($category->products as $product) {

            if ($product->media->count() > 0) {

                foreach ($product->media as $media) {

                    if (File::exists('assets/products/' . $media->file_name)) {

                        unlink('assets/products/' . $media->file_name);
                    }
                }
            }
        }

        $category->delete();

        return redirect()->route('admin.product_categories.index')->with([

            'message' => 'تم حذف الفئة بنجاح',

            'alert-type' => 'success',
        ]);
    }
}

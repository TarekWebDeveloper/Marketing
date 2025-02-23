<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Category;
use App\Models\Page;
use App\Models\Product;
use App\Models\ProductImage;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Validator;
use Intervention\Image\Facades\Image;
use Stevebauman\Purify\Facades\Purify;
class PagesController extends Controller
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
        if (!\auth()->user()->ability('admin', 'manage_pages,show_pages')) {
            return redirect('admin/index');
        }

        $keyword = (isset(\request()->keyword) && \request()->keyword != '') ?
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


        $pages = Page::whereProductType('page');
        if ($keyword != null) {
            $pages = $pages->search($keyword);
        }

        if ($categoryId != null) {
            $pages = $pages->whereCategoryId($categoryId);
        }
        if ($status != null) {
            $pages = $pages->whereStatus($status);
        }

        $pages = $pages->orderBy($sort_by, $order_by);
        $pages = $pages->paginate($limit_by);

        $categories = Category::orderBy('id', 'desc')->pluck('name', 'id');

        return view('backend.pages.index', compact('categories', 'pages'));

    }

    //create page
    public function create()
    {
        if (!\auth()->user()->ability('admin', 'create_pages')) {
            return redirect('admin/index');
        }

        $categories = Category::orderBy('id', 'desc')->pluck('name', 'id');

        return view('backend.pages.create', compact('categories'));
    }

    public function store(Request $request)
    {
        if (!\auth()->user()->ability('admin', 'create_pages')) {
            return redirect('admin/index');
        }

        $validator = Validator::make($request->all(), [
            'title'         => 'required',

            'description'   => 'required|min:50',

            'status'        => 'required',

            'category_id'   => 'required',

            'images.*'      => 'nullable|mimes:jpg,jpeg,png,gif|max:20000',
        ]);
        if($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $data['title']              = $request->title;

        $data['description']        = Purify::clean($request->description);

        $data['status']             = $request->status;

        $data['product_type']          = 'page';

        $data['comment_able']       = 0;

        $data['category_id']        = $request->category_id;

        $page = auth()->user()->products()->create($data);

        if ($request->images && count($request->images) > 0) {
            $i = 1;
            foreach ($request->images as $file) {

                $filename = $page->slug.'-'.time().'-'.$i.'.'.$file->getClientOriginalExtension();

                $file_size = $file->getSize();

                $file_type = $file->getMimeType();

                $path = public_path('assets/image_product/' . $filename);

                Image::make($file->getRealPath())->resize(800, null, function ($constraint) {

                    $constraint->aspectRatio();

                })->save($path, 100);

                $page->media()->create([
                    'file_name' => $filename,

                    'file_size' => $file_size,

                    'file_type' => $file_type,
                ]);
                $i++;
            }
        }

        return redirect()->route('admin.pages.index')->with([
            'message' => 'تم إنشاء الصفحة بنجاح',
            'alert-type' => 'success',
        ]);
    }


    //show page

    public function show($id)
    {
        if (!\auth()->user()->ability('admin', 'display_pages')) {
            return redirect('admin/index');
        }

        $page = Page::with(['media'])->whereId($id)->whereProductType('page')->first();

        return view('backend.pages.show', compact('page'));
    }



    //edit page
    public function edit($id)
    {
        if (!\auth()->user()->ability('admin', 'update_pages')) {
            return redirect('admin/index');
        }

        $categories = Category::orderBy('id', 'desc')->pluck('name', 'id');

        $page = Page::with(['media'])->whereId($id)->whereProductType('page')->first();

        return view('backend.pages.edit', compact('categories', 'page'));
    }






    //update page

    public function update(Request $request, $id)
    {
        if (!\auth()->user()->ability('admin', 'update_pages')) {

            return redirect('admin/index');
        }

        $validator = Validator::make($request->all(), [
            'title'         => 'required',

            'description'   => 'required|min:50',

            'status'        => 'required',

            'category_id'   => 'required',

            'images.*'      => 'nullable|mimes:jpg,jpeg,png,gif|max:20000',
        ]);
        if($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $page = Page::whereId($id)->whereProductType('page')->first();

        if ($page) {
            $data['title']              = $request->title;
            $data['slug']               = null;
            $data['description']        = Purify::clean($request->description);
            $data['status']             = $request->status;
            $data['category_id']        = $request->category_id;

            $page->update($data);

            if ($request->images && count($request->images) > 0) {

                $i = 1;

                foreach ($request->images as $file) {

                    $filename = $page->slug.'-'.time().'-'.$i.'.'.$file->getClientOriginalExtension();

                    $file_size = $file->getSize();

                    $file_type = $file->getMimeType();

                    $path = public_path('assets/image_product/' . $filename);

                    Image::make($file->getRealPath())->resize(800, null, function ($constraint) {

                        $constraint->aspectRatio();

                    })->save($path, 100);

                    $page->media()->create([
                        'file_name' => $filename,
                        'file_size' => $file_size,
                        'file_type' => $file_type,
                    ]);
                    $i++;
                }
            }

            return redirect()->route('admin.pages.index')->with([
                'message' => 'تم تحديث الصفحة بنجاح',
                'alert-type' => 'success',
            ]);

        }
        return redirect()->route('admin.pages.index')->with([
            'message' => 'فشلت العملية ',
            'alert-type' => 'danger',
        ]);
    }



    //destroy page

    public function destroy($id)
    {
        if (!\auth()->user()->ability('admin', 'delete_pages')) {
            return redirect('admin/index');
        }

        $page = Page::whereId($id)->whereProductType('page')->first();

        if ($page) {
            if ($page->media->count() > 0) {
                foreach ($page->media as $media) {
                    if (File::exists('assets/image_product/' . $media->file_name)) {
                        unlink('assets/image_product/' . $media->file_name);
                    }
                }
            }
            $page->delete();

            return redirect()->route('admin.pages.index')->with([
                'message' => 'تم حذف الصفحة بنجاح',
                'alert-type' => 'success',
            ]);
        }

        return redirect()->route('admin.pages.index')->with([
            'message' => 'فشلت العملية ',
            'alert-type' => 'danger',
        ]);
    }


    //removeImage

    public function removeImage(Request $request)
    {
        if (!\auth()->user()->ability('admin', 'delete_pages')) {
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

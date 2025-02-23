<?php








namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Category;
use App\Models\Comment;
use App\Models\PostMedia;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use Intervention\Image\Facades\Image;
use Stevebauman\Purify\Facades\Purify;











class PrivateController extends Controller
{



    public function __construct()
    {
        $this->middleware(['auth', 'verified']);
    }



    //dashboard

    public function index()
    {
       $products = auth()->user()->products()

     // ->with(['media', 'category', 'user'])

       ->withCount('comments')

       ->orderBy('id', 'desc')

       ->paginate(10);

        return view('frontend.auth_users.dashboard', compact('products'));
    }




// Show Comments

    public function show_comments(Request $request)
    {

        $comments = Comment::query();

        if (isset($request->product) && $request->product != '') {

            $comments = $comments->whereProductId($request->product);

        } else {

            $products_id = auth()->user()->products->pluck('id')->toArray();
            
           $comments = $comments->whereIn('product_id', $products_id);
        }
        $comments = $comments->orderBy('id', 'desc')->paginate(10);

       // $comments = $comments->paginate(10);

        return view('frontend.auth_users.comments', compact('comments'));
    }






//Modify the information
   
   
    public function edit_information()
    {
        return view('frontend.auth_users.edit_information');
    }




//update the information
    public function update_information(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name'          => 'required',
            'email'         => 'required|email',
            'mobile'        => 'required|numeric',
            'bio'           => 'nullable|min:10',
            'receive_email' => 'required',
            'user_image'    => 'nullable|image|max:20000,mimes:jpeg,jpg,png'
        ]);
        if($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $data['name']           = $request->name;
        $data['email']          = $request->email;
        $data['mobile']         = $request->mobile;
        $data['bio']            = $request->bio;
        $data['receive_email']  = $request->receive_email;


        //Is there a image
        //delete the old image

        if ($image = $request->file('user_image')) {

            if (auth()->user()->user_image != ''){

                if (File::exists('/assets/users/' . auth()->user()->user_image)){

                    unlink('/assets/users/' . auth()->user()->user_image);
                }
            }

          //Add image


            $filename = Str::slug(auth()->user()->username).'.'.$image->getClientOriginalExtension();

            $path = public_path('assets/users/' . $filename);

            Image::make($image->getRealPath())->resize(300, 300, function ($constraint) {

                $constraint->aspectRatio();

            })->save($path, 100);

            $data['user_image'] = $filename;
        }


        $update = auth()->user()->update($data);

        if ($update) {
            return redirect()->back()->with([
                'message' => '  تم تحديث المعلومات بنجاح',
                'alert-type' => 'success',
            ]);
        } else {
            return redirect()->back()->with([
                'message' => 'تم فشل العملية   ',
                'alert-type' => 'danger',
            ]);
        }

    }



//Password Update

    public function update_password(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'current_password'  => 'required',
            'password'          => 'required|confirmed'
        ]);
        if($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $user = auth()->user();
        if (Hash::check($request->current_password, $user->password)) {
            $update = $user->update([
                'password' => bcrypt($request->password),
            ]);

            if ($update) {
                return redirect()->back()->with([
                    'message' => 'تم تحديث كلمة السر  بنجاح',
                    'alert-type' => 'success',
                ]);
            } else {
                return redirect()->back()->with([
                    'message' => 'فشلت العملية   ',
                    'alert-type' => 'danger',
                ]);
            }

        } else {
            return redirect()->back()->with([
                'message' => ' فشلت العملية  ',
                'alert-type' => 'danger',
            ]);
        }
    }






//new product

    public function create_product()
    {
        $categories = Category::whereStatus(1)->pluck('name', 'id');
        
        return view('frontend.auth_users.create_post', compact('categories'));
    }



    //Store Product

    public function store_product(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'title'         => 'required',
            'description'   => 'required|min:50',
            'status'        => 'required',
            'comment_able'  => 'required',
            'category_id'   => 'required',
        ]);
        if($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $data['title']              = $request->title;
        $data['description']        = Purify::clean($request->description);
        $data['status']             = $request->status;
        $data['comment_able']       = $request->comment_able;
        $data['category_id']        = $request->category_id;

        $product = auth()->user()->products()->create($data);

        if ($request->images && count($request->images) > 0) {
            $i = 1;
            foreach ($request->images as $file) {
                $filename = $product->category_id.'-'.time().'-'.$i.'.'.$file->getClientOriginalExtension();
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
            Cache::forget('recent_posts');
        }

        return redirect()->back()->with([
            'message' => 'تم إنشاء المنتج بنجاح',
            'alert-type' => 'success',
        ]);

    }


//Edit Product
        public function edit_product($product_id)
        {
            $product = Product::whereSlug($product_id)
            ->orWhere('id', $product_id)
            ->whereUserId(auth()->id())
            ->first();

    
            if ($product) {
                $categories = Category::whereStatus(1)->pluck('name', 'id');
                return view('frontend.auth_users.edit_post', compact('product', 'categories'));
            }
    
            return redirect()->route('frontend.home');
        }




//Update Product

        public function update_product(Request $request, $post_id)
        {
            $validator = Validator::make($request->all(), [
                'title'         => 'required',
                'description'   => 'required|min:50',
                'status'        => 'required',
                'comment_able'  => 'required',
                'category_id'   => 'required',
            ]);
            if($validator->fails()) {
                return redirect()->back()->withErrors($validator)->withInput();
            }
            $post = Product::whereSlug($post_id)
            ->orWhere('id', $post_id)
            ->whereUserId(auth()
            ->id())
            ->first();
    
            if ($post) {
                $data['title']              = $request->title;
                $data['description']        = Purify::clean($request->description);
                $data['status']             = $request->status;
                $data['comment_able']       = $request->comment_able;
                $data['category_id']        = $request->category_id;
    
                $post->update($data);
    
                if ($request->images && count($request->images) > 0) {
                    $i = 1;
                    foreach ($request->images as $file) {
                        $filename = $post->slug.'-'.time().'-'.$i.'.'.$file->getClientOriginalExtension();
                        $file_size = $file->getSize();
                        $file_type = $file->getMimeType();
                        $path = public_path('assets/image_product/' . $filename);
                        Image::make($file->getRealPath())->resize(800, null, function ($constraint) {
                            $constraint->aspectRatio();
                        })->save($path, 100);
    
                        $post->media()->create([
                            'file_name' => $filename,
                            'file_size' => $file_size,
                            'file_type' => $file_type,
                        ]);
                        $i++;
                    }
                }
    
                return redirect()->back()->with([
                    'message' => 'تم تحديث المنتج بنجاح  ',
                    'alert-type' => 'success',
                ]);
    
            }
            return redirect()->back()->with([
                'message' => ' فشلت العملية  ',
                'alert-type' => 'danger',
            ]);
    
        }




        //Destroy Product
    
        public function destroy_product($product_id)
        {
            $post = Product::whereSlug($product_id)
            ->orWhere('id', $product_id)
            ->whereUserId(auth()
            ->id())
            ->first();
    
            if ($post) {
                if ($post->media->count() > 0) {
                    foreach ($post->media as $media) {
                        if (File::exists('assets/image_product/' . $media->file_name)) {
                            unlink('assets/image_product/' . $media->file_name);
                        }
                    }
                }

                $post->delete();
    
                return redirect()->back()->with([
                    'message' => 'تم حذف المنتج بنجاح',
                    'alert-type' => 'success',
                ]);
            }
    
            return redirect()->back()->with([
                'message' => 'فشلت العملية   ',
                'alert-type' => 'danger',
            ]);
    
        }




    // Destroy Product Image
    
        public function  destroy_product_image($image_id)
        {
           $image = ProductImage::whereId($media_id)->first();
            if ($media) {
                if (File::exists('assets/image_product/' . $image->file_name)) {

                    unlink('assets/image_product/' . $image->file_name);
                }

                 $image->delete();
                return true;
            }
            return false;
        }







    //Edit Comment
        public function edit_comment($comment_id)
        {
            $comment = Comment::whereId($comment_id)->whereHas('product', function ($query) {
                $query->where('products.user_id', auth()->id());
            })->first();
    
            if ($comment) {
                return view('frontend.auth_users.edit_comment', compact('comment'));
            } else {
                return redirect()->back()->with([
                    'message' => 'فشلت العملية   ',
                    'alert-type' => 'danger',
                ]);
            }
    
        }




    //Update Comment
        public function update_comment(Request $request, $comment_id)
        {
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
    
            $comment = Comment::whereId($comment_id)->whereHas('product', function ($query) {
                $query->where('products.user_id', auth()->id());
            })->first();
    
            if ($comment) {
                $data['name']          = $request->name;
                $data['email']         = $request->email;
                $data['url']           = $request->url != '' ? $request->url : null;
                $data['status']        = $request->status;
                $data['comment']       = Purify::clean($request->comment);
    
                $comment->update($data);
    
                if ($request->status == 1) {
                    Cache::forget('recent_comments');
                }
    
                return redirect()->back()->with([
                    'message' => 'تم تحديث التعليق بنجاح',
                    'alert-type' => 'success',
                ]);
    
            } else {
                return redirect()->back()->with([
                    'message' => 'فشلت العملية   ',
                    'alert-type' => 'danger',
                ]);
            }
    
        }
    



    //Destroy Comment
        public function destroy_comment($comment_id)
        {
            $comment = Comment::whereId($comment_id)->whereHas('product', function ($query) {
                $query->where('products.user_id', auth()->id());
            })->first();
    
            if ($comment) {
                $comment->delete();
    
                Cache::forget('recent_comments');
    
                return redirect()->back()->with([
                    'message' => 'تم حذف التعليق بنجاج',
                    'alert-type' => 'success',
                ]);
    
            } else {
                return redirect()->back()->with([
                    'message' => 'فشلت العملية   ',
                    'alert-type' => 'danger',
                ]);
            }

        }
    


       
            



    }
        
    
    
    
           
        
        
        

           






    
    









    



            
        
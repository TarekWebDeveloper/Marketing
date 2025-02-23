<?php




namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Contact;
use App\Models\Product;
use App\Models\User;
use App\Notifications\NewCommentNoti;
use App\Notifications\NewCommentForAdminNotify;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Stevebauman\Purify\Facades\Purify;
















class IndexController extends Controller
{


// All products function
    
   public function index()
    {
        $products = Product::with([ 'user','category'])
                         
        ->whereHas('category', function ($query) {
           $query->whereStatus(1);
        })

        ->whereHas('user', function ($query) {

            $query->whereStatus(1);
       })

        ->product()->effective()->orderBy('id', 'desc')->paginate(8);
       
        return view('frontend.home', compact('products'));

   }




//  product details   function


    public function product_show($slug)
    {

       
 //Active comments only
 $product = Product::with(['category', 'user',

 'active_comments' => function($query) {

     $query->orderBy('id', 'desc');

 }
]);
//Active category only

$product = $product->whereHas('category', function ($query) {
    $query->whereStatus(1);
 })
//Active user only

 ->whereHas('user', function ($query) {
     $query->whereStatus(1);
 });

$product = $product->whereSlug($slug);
//product user only

$product = $product->effective()->first();

if($product) {

 $product_details = $product->product_type == 'product' ? 'product' : 'page';

 return view('frontend.' . $product_details, compact('product'));

} else {

 return redirect()->route('frontend.home');
}
    }








    // publisher function

    public function publisher($username)
    {
      //User ID

      $user = User::whereUsername($username)->whereStatus(1)->first()->id;

        if ($user) {

            $products = Product::with(['media', 'user'])

                ->whereUserId($user)                         // Bring all user posts

                ->product()                                  //product_type

                ->effective()                                //active==1

                ->orderBy('id', 'desc')
                
                ->paginate(5);

            return view('frontend.home', compact('products'));
        }

        return redirect()->route('frontend.home');
    }




     // Connect with us function


    public function store_contact(Request $request)
    {

        //dd($request->all(),$slug);

        $validation = Validator::make($request->all(), [
            'name'      => 'required',

            'email'     => 'required|email',

            'mobile'    => 'nullable|numeric',

            'title'     => 'required|min:5',

            'message'   => 'required|min:10',
        ]);

        if ($validation->fails()){

            return redirect()->back()->withErrors($validation)->withInput();
        }
    
        $data['name']       = $request->name;

        $data['email']      = $request->email;

        $data['mobile']     = $request->mobile;

        $data['title']      = $request->title;

        $data['message']    = $request->message;
    
        Contact::create($data);
    
        return redirect()->back()->with([

            'message' => 'تم ارسال الرسالة بنجاح',

            'alert-type' => 'success'
        ]);

    }



     //Contact us page 

    public function contact()
    {
        return view('frontend.contact');
    }


  

     // search function 



    public function search(Request $request)
    {
        $keyword = isset($request->keyword) && $request->keyword != '' ? $request->keyword : null;

        $products = Product::with(['category', 'user'])
            ->whereHas('category', function ($query) {
                $query->whereStatus(1);
            })
            ->whereHas('user', function ($query) {
                $query->whereStatus(1);
            });

        if ($keyword != null) {
          $products = $products->search($keyword, null, true);
        }

       $products = $products->product()

                            ->effective()

                            ->orderBy('id', 'desc')

                            ->paginate(5);

        return view('frontend.home', compact('products'));
    }



     // category function 

    public function category($slug)
    {
        $category = Category::whereSlug($slug)->orWhere('id', $slug)->whereStatus(1)->first()->id;

                                              
                                                                           

        if ($category) {

            $products = Product::with(['user'])

                ->whereCategoryId($category)

                ->product()

                ->effective()

                ->orderBy('id', 'desc')

                ->paginate(4);

            return view('frontend.home', compact('products'));
        }

        return redirect()->route('frontend.home');
    }





     // archive function 

    public function archive($date)
    {
        $exploded_date = explode('-', $date);

        $month = $exploded_date[0];

        $year = $exploded_date[1];

        $products = Product::with(['user'])

            ->whereMonth('created_at', $month)

            ->whereYear('created_at', $year)

            ->product()

            ->effective()

            ->orderBy('id', 'desc')

            ->paginate(6);

        return view('frontend.home', compact('products'));

    }







   
    //storecomment function 

   

    public function store_comment(Request $request, $slug)
    {
        //conditions

        $validation = Validator::make($request->all(), [
            'name'      => 'required',
            'email'     => 'required|email',
            'url'       => 'nullable|url',
            'comment'   => 'required|min:10',
        ]);


         //fails
        if ($validation->fails()){
            return redirect()->back()->withErrors($validation)->withInput();
        }

        // insert

    
        $product = Product::whereSlug($slug)->product()->effective()->first();
       
        if ($product) {

            $userId = auth()->check() ? auth()->id() : null;

            $data['name']           = $request->name;

            $data['email']          = $request->email;

            $data['url']            = $request->url;

            $data['ip_address']     = $request->ip();

            $data['comment']        = Purify::clean($request->comment);

            $data['product_id']     = $product->id;

            $data['user_id']        = $userId;

            $comment = $product->comments()->create($data);












            //Notifications

            if (auth()->guest() || auth()->id() != $product->user_id) {

                $product->user->notify(new NewCommentNoti($comment));
            }

            User::whereHas('roles', function ($query) {

                $query->whereIn('name', ['admin', 'editor']);

           })->each(function ($admin, $key) use ($comment) {

              $admin->notify(new NewCommentForAdminNotify($comment));
            });

            return redirect()->back()->with([

                'message' => 'تم اضافة التعليق بنجاح',
                
                'alert-type' => 'success'
           ]);
       }

        return redirect()->back()->with([
            'message' => 'فشل العملية ',
            'alert-type' => 'danger'
        ]);

    }


}

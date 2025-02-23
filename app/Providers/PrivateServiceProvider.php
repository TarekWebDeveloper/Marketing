<?php

namespace App\Providers;
use App\Models\Category;
use App\Models\Comment;
use App\Models\Permission;
use App\Models\Product;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\ServiceProvider;

class PrivateServiceProvider extends ServiceProvider
{
     /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        if (!request()->is('admin/*')) {
            Paginator::defaultView('vendor.pagination.pagination');

            view()->composer('*', function ($view) {


                


                //recent_products

                if (!Cache::has('recent_products')) {

                    $recent_products = Product::with(['category', 'media', 'user'])

                        ->whereHas('category', function ($query) {

                            $query->whereStatus(1);
                        })

                        ->whereHas('user', function ($query) {
                            $query->whereStatus(1);
                        })

                        ->whereproductType('product')->whereStatus(1)->orderBy('id', 'desc')->limit(5)->get();

                    Cache::remember('recent_products', 3600, function () use ($recent_products){

                        return $recent_products;
                    });
                }
                $recent_products = Cache::get('recent_products');





                //recent_comments


                if (!Cache::has('recent_comments')) {
                    $recent_comments = Comment::whereStatus(1)->orderBy('id', 'desc')->limit(7)->get();

                    Cache::remember('recent_comments', 3600, function () use ($recent_comments){
                        return $recent_comments;
                    });
                }
                $recent_comments = Cache::get('recent_comments');


               //categories

                if (!Cache::has('mycache_categories')) {
                    
                    $mycache_categories = Category::whereStatus(1)->orderBy('id', 'desc')->get();

                    Cache::remember('mycache_categories', 3600, function () use ($mycache_categories){
                        return $mycache_categories;
                    });
                }
                $mycache_categories = Cache::get('mycache_categories');







                //mycache_archives

                if (!Cache::has('mycache_archives')) {

                    $mycache_archives = Product::whereStatus(1)->orderBy('created_at', 'desc')

                        ->select(DB::raw("Year(created_at) as year"), DB::raw("Month(created_at) as month"))

                        ->pluck('year', 'month')->toArray();

                    Cache::remember('mycache_archives', 3600, function () use ($mycache_archives){

                        return $mycache_archives;

                    });
                }
                $mycache_archives = Cache::get('mycache_archives');



                $view->with([
                    'recent_products' => $recent_products,
                    'recent_comments' => $recent_comments,
                    'mycache_categories' => $mycache_categories,
                    'mycache_archives' => $mycache_archives,
                ]);

            });

        }
    

   
               









     if (request()->is('admin/*') || request()->is('admin')){

        view()->composer('*', function ($view) {
    // اذا مو مكيش كيشو  
            if (!Cache::has('Main_menu')) {
                // يعني أستدعي لي القائمة الرئيسة والقوائم الفرعية يلي تحتها 

                Cache::forever('Main_menu', Permission::tree());
            }
            $Main_menu = Cache::get('Main_menu');

            $view->with([
               'Main_menu' => $Main_menu,
            ]);

       });

    }

}
}









   

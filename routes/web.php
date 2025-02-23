<?php

//Bring all posts
 Route::get('/',
           ['as' => 'frontend.home',      
           'uses' => 'Frontend\IndexController@index']);



// user Routes.
Route::get('/login',
          ['as' => 'frontend.show_login_form',  
          'uses' => 'Frontend\Auth\LoginController@showLoginForm']);

Route::post('login',  
           ['as' => 'frontend.login',                 
            'uses' => 'Frontend\Auth\LoginController@login']);


Route::get('logout', 
           ['as' => 'logout',    
           'uses' => 'Frontend\Auth\LoginController@logout']);


Route::get('register',
          ['as' => 'frontend.show_register_form', 
          'uses' => 'Frontend\Auth\RegisterController@showRegistrationForm']);


Route::post('register',  
           ['as' => 'frontend.register',   
           'uses' => 'Frontend\Auth\RegisterController@register']);


Route::get('password/reset',                    
          ['as' => 'password.request',  
          'uses' => 'Frontend\Auth\ForgotPasswordController@showLinkRequestForm']);

Route::post('password/email',                   
           ['as' => 'password.email',                  
           'uses' => 'Frontend\Auth\ForgotPasswordController@sendResetLinkEmail']);


Route::get('password/reset/{token}',            
          ['as' => 'password.reset',                  
          'uses' => 'Frontend\Auth\ResetPasswordController@showResetForm']);

Route::post('password/reset',                   
           ['as' => 'password.update',                 
           'uses' => 'Frontend\Auth\ResetPasswordController@reset']);

Route::get('email/verify',                     
          ['as' => 'verification.notice',             
          'uses' => 'Frontend\Auth\VerificationController@show']);

Route::get('/email/verify/{id}/{hash}',         
          ['as' => 'verification.verify',             
          'uses' => 'Frontend\Auth\VerificationController@verify']);

Route::post('email/resend',                     
           ['as' => 'verification.resend',             
           'uses' => 'Frontend\Auth\VerificationController@resend']);





Route::group(['middleware' => 'verified'], function () {

  //dashboard
    Route::get('/dashboard', 
              ['as' => 'dashboard',             
               'uses' => 'Frontend\PrivateController@index']);
               

   
// Edit information 

    Route::get('/edit-info', 
              ['as' => 'edit_information',  
               'uses' => 'Frontend\PrivateController@edit_information']);

    Route::post('/edit-info', 
               ['as' => 'update_information',  
                'uses' => 'Frontend\PrivateController@update_information']);

// Edit passwoed
    Route::post('/edit-password',
               ['as' => 'update_password',  
                'uses' => 'Frontend\PrivateController@update_password']);

//new product

    Route::get('/create-product',
              ['as' => 'product.create',  
               'uses' => 'Frontend\PrivateController@create_product']);


               
    Route::post('/create-product',  
                   ['as' => 'product.store',  
                    'uses' => 'Frontend\PrivateController@store_product']);

//Edit my post 
    Route::get('/edit-product/{product_id}',
              ['as' => 'product.edit', 
              'uses' => 'Frontend\PrivateController@edit_product']);



    Route::put('/edit-product/{product_id}',  
              ['as' => 'product.update',         
               'uses' => 'Frontend\PrivateController@update_product']);
 
 //Delete my post 
    Route::delete('/delete-product/{product_id}', 
                  ['as' => 'product.destroy',  
                    'uses' => 'Frontend\PrivateController@destroy_product']);
 //Delete my post 

    Route::post('/delete-product-image/{$image_id}',
               ['as' => 'product.image.destroy',  
                'uses' => 'Frontend\PrivateController@destroy_product_image']);

//comments
    Route::get('/comments', 
              ['as' => 'comments',
               'uses' => 'Frontend\PrivateController@show_comments']);

//ُEdit comment

    Route::get('/edit-comment/{comment_id}', 
              ['as' => 'comment.edit',   
               'uses' => 'Frontend\PrivateController@edit_comment']);


    Route::put('/edit-comment/{comment_id}',  
              ['as' => 'comment.update',       
               'uses' => 'Frontend\PrivateController@update_comment']);

// Delete comment
    Route::delete('/delete-comment/{comment_id}',
                 ['as' => 'comment.destroy',    
                  'uses' => 'Frontend\PrivateController@destroy_comment']);

});






Route::group(['prefix' => 'admin'], function() {

    // admin Routes...
   

    Route::get('/login',                            
              ['as' => 'admin.show_login_form',       
              'uses' => 'Backend\Auth\LoginController@showLoginForm']);


    Route::post('login',                            
               ['as' => 'admin.login',                
               'uses' => 'Backend\Auth\LoginController@login']);

    Route::post('logout',                           
               ['as' => 'admin.logout',                
               'uses' => 'Backend\Auth\LoginController@logout']);

    Route::get('password/reset',                    
              ['as' => 'admin.password.request',      
              'uses' => 'Backend\Auth\ForgotPasswordController@showLinkRequestForm']);

    Route::post('password/email',                  
               ['as' => 'admin.password.email',        
               'uses' => 'Backend\Auth\ForgotPasswordController@sendResetLinkEmail']);

    Route::get('password/reset/{token}',            
              ['as' => 'admin.password.reset',        
              'uses' => 'Backend\Auth\ResetPasswordController@showResetForm']);

    Route::post('password/reset',                   
               ['as' => 'admin.password.update',       
               'uses' => 'Backend\Auth\ResetPasswordController@reset']);







        Route::group(['middleware' => ['roles', 'role:admin|editor']], function() {
       
        //home page 

        Route::get('/',  
     
       ['as' => 'admin.index.route',      
       'uses' => 'Backend\AdminController@index']);


        Route::get('home',  
        ['as' => 'admin.index',   
         'uses' => 'Backend\AdminController@index']);


        Route::post('/posts/removeImage/{image_id}',
        ['as' => 'admin.products.image.destroy', 
        'uses' => 'Backend\ProductsController@removeImage']);



        Route::resource('products',  
        'Backend\ProductsController', 
         ['as' => 'admin']);


        Route::post('/pages/removeImage/{image_id}',
        ['as' => 'admin.pages.image.destroy', 
         'uses' => 'Backend\PagesController@removeImage']);


        Route::resource('pages',  
        'Backend\PagesController',
         ['as' => 'admin']);


        Route::resource('product_comments',  
        'Backend\ProductCommentsController',
        ['as' => 'admin']);

        Route::resource('product_categories',
        'Backend\ProductCategoriesController', 
         ['as' => 'admin']);

        Route::resource('contact_us', 
         'Backend\ContactUsController',
          ['as' => 'admin']);

        Route::post('/users/removeImage', 
        ['as' => 'admin.users.remove_image',
         'uses' => 'Backend\UsersController@removeImage']);

        Route::resource('users',  
         'Backend\UsersController', 
         ['as' => 'admin']);


        Route::post('/supervisors/removeImage', 
         ['as' => 'admin.supervisors.remove_image', 
         'uses' => 'Backend\SupervisorsController@removeImage']);


        Route::resource('supervisors',  
         'Backend\SupervisorsController',
          ['as' => 'admin']);

        Route::resource('settings',  
        'Backend\SettingsController', 
        ['as' => 'admin']);

    });

});

//contact-us

Route::get('/contact-us',
           ['as' => 'frontend.contact', 
            'uses' => 'Frontend\IndexController@contact']);

Route::post('/contact-us', 
            ['as' => 'frontend.store_contact',  
            'uses' => 'Frontend\IndexController@store_contact']);

//Posts that belong to a specific category
Route::get('/category/{category_slug}', 
           ['as' => 'frontend.category.products',   
           'uses' => 'Frontend\IndexController@category']);

Route::get('/archive/{date}',  
          ['as' => 'frontend.archive.products',  
          'uses' => 'Frontend\IndexController@archive']);

//Posts of a specific user
Route::get('/publisher/{username}',  
           ['as' => 'frontend.publisher.products',   
           'uses' => 'Frontend\IndexController@publisher']);

//Search for posts based on title
Route::get('/search',   

          ['as' => 'frontend.search',    
          'uses' => 'Frontend\IndexController@search']);



//Bring a specific post   
  Route::get('/{product}', 
          ['as' => 'products.show',  
           'uses' => 'Frontend\IndexController@product_show']);

//
Route::post('/{product}',  
            ['as' => 'products.add_comment', 
             'uses' => 'Frontend\IndexController@store_comment']);
<?php

use App\Models\Permission;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PermissionTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        DB::statement('SET FOREIGN_KEY_CHECKS=0;');

        DB::table('permissions')->truncate();


        // Main

        $manageMain = Permission::create([
            'name' => 'main',

            'display_name' => 'رئيسية',

            'description' => 'Administrator',

            'route' => 'index', 

            'module' => 'index',

            'as' => 'index',

            'icon' => 'fa fa-home',

            'parent' => '0', 

            'parent_original' => '0', 

            'sidebar_link' => '1', 

            'appear' => '1', 

            'ordering' => '1',]);


         $manageMain->parent_show = $manageMain->id; $manageMain->save();

        

        // POSTS

        $manageProducts = Permission::create([ 
        'name' => 'manage_products', 

        'display_name' => 'ادارة المنتجات', 

        'route' => 'products', 

        'module' => 'products', 


        'icon' => 'fas fa-newspaper',

        'parent' => '0',

        'parent_original' => '0',

        'appear' => '1', 

        'ordering' => '5', ]);

        $manageProducts->parent_show = $manageProducts->id; $manageProducts->save();


        $showProducts = Permission::create([ 

            'name' => 'show_products',

             'display_name' => 'عرض المنتجات', 

             'route' => 'products',

              'module' => 'products', 

              'as' => 'products.index', 

              'icon' => 'fas fa-newspaper', 

              'parent' => $manageProducts->id, 

              'parent_show' => $manageProducts->id, 

              'parent_original' => $manageProducts->id,

               'appear' => '1', 

               'ordering' => '0', ]);

        $createProducts = Permission::create([

              'name' => 'create_products', 

              'display_name' => 'منتج جديد', 

             'route' => 'products/create', 

              'module' => 'products', 

              'as' => 'products.create',

              'icon' => null, 

              'parent' => $manageProducts->id, 

              'parent_show' => $manageProducts->id,

              'parent_original' => $manageProducts->id,

              'appear' => '0',

              'ordering' => '0',]);


        $displayProduct = Permission::create([
             'name' => 'display_products', 

             'display_name' => 'عرض المنتجات', 

             'route' => 'products/{products}', 

             'module' => 'products', 

             'as' => 'products.show', 

             'icon' => null, 

             'parent' => $manageProducts->id,

             'parent_show' => $manageProducts->id, 

            'parent_original' => $manageProducts->id,

            'appear' => '0',

            'ordering' => '0', ]);


        $updateProducts = Permission::create([
             'name' => 'update_products',

              'display_name' => 'تحديث المنتج',

               'route' => 'products/{products}/edit',

                'module' => 'products', 

                'as' => 'products.edit', 

                'icon' => null, 

                'parent' => $manageProducts->id, 

                'parent_show' => $manageProducts->id,

                'parent_original' => $manageProducts->id, 

                'appear' => '0', 

                'ordering' => '0', ]);

        $destroyProducts = Permission::create([ 
            'name' => 'delete_products',

            'display_name' => 'حذف المنتج',

            'route' => 'products/{products}',

            'module' => 'products',

            'as' => 'products.delete',

            'icon' => null, 

            'parent' => $manageProducts->id,

            'parent_show' => $manageProducts->id,

            'parent_original' => $manageProducts->id,

            'appear' => '0',

            'ordering' => '0', ]);

        // POSTS COMMENTS
        $manageComments = Permission::create([ 
            'name' => 'manage_products_comments',

            'display_name' => 'ادارة تعليقات المنتج ',

            'route' => 'product_comments', 

             'module' => 'product_comments',

             'as' => 'product_comments.index', 

            'icon' => 'fas fa-comments-alt', 

            'parent' => $manageProducts->id,

            'parent_original' => '0',

            'appear' => '0', 

            'ordering' => '10', ]);

        $manageComments->parent_show = $manageComments->id; $manageComments->save();

        $showComments = Permission::create([ 
            'name' => ' show_products_comments', 

            'display_name' => 'عرض تعليقات المنتج  ', 

            'route' => 'product_comments', 

            'module' => 'product_comments', 

            'as' => 'product_comments.index',

            'icon' => 'fas fa-comments-alt', 

            'parent' => $manageProducts->id,

            'parent_show' => $manageProducts->id, 

            'parent_original' => $manageComments->id,

            'appear' => '1', 

            'ordering' => '0', ]);




        $updateComments = Permission::create([ 
            'name' => 'update_products_comments',

            'display_name' => 'تحديث تعليقات',

            'route' => 'product_comments/{product_comments}/edit', 

            'module' => 'product_comments',

            'as' => 'product_comments.edit', 

            'icon' => null, 

            'parent' => $manageProducts->id, 

            'parent_show' => $manageProducts->id, 

            'parent_original' => $manageComments->id, 

            'appear' => '0', 

            'ordering' => '0', ]);

        $destroyComments = Permission::create([ 
            'name' => 'delete_products_comments', 

            'display_name' => 'حذف التعليق',

            'route' => 'product_comments/{product_comments}',

            'module' => 'product_comments', 

            'as' => 'product_comments.delete', 

            'icon' => null, 

            'parent' => $manageProducts->id,

            'parent_show' => $manageProducts->id, 

            'parent_original' => $manageComments->id,

            'appear' => '0',

            'ordering' => '0', ]);

        // POSTS CATEGORIES
        $manageProductCategories = Permission::create([ 
            'name' => 'manage_products_categories',

            'display_name' => 'ادارة الفئات',

            'route' => 'product_categories',

            'module' => 'product_categories', 

            'as' => 'product_categories.index', 

            'icon' => 'fas fa-file-archive',

            'parent' => $manageProducts->id, 

            'parent_original' => '0',

            'appear' => '0', 

            'ordering' => '15', ]);


        $manageProductCategories->parent_show = $manageProductCategories->id; $manageProductCategories->save();




        $showProductCategories = Permission::create([
             'name' => 'show_product_categories', 

             'display_name' => 'عرض الفئات',

             'route' => 'product_categories', 

             'module' => 'product_categories', 

             'as' => 'product_categories.index', 

             'icon' => 'fas fa-file-archive', 

             'parent' => $manageProducts->id, 

             'parent_show' => $manageProducts->id, 

             'parent_original' => $manageProductCategories->id,

             'appear' => '1', 

             'ordering' => '0', ]);

        $createProductCategories = Permission::create([
             'name' => 'create_product_categories',

             'display_name' => ' فئة جديدة',

             'route' => 'product_categories/create', 

             'module' => 'product_categories', 

             'as' => 'product_categories.create',

             'icon' => null, 

             'parent' => $manageProducts->id,

             'parent_show' => $manageProducts->id,

             'parent_original' => $manageProductCategories->id,

             'appear' => '0', 'ordering' => '0',]);

        $updateProductCategories = Permission::create([ 
            'name' => 'update_product_categories',

             'display_name' => 'تحديث الفئة ', 

             'route' => 'product_categories/{product_categories}/edit',

             'module' => 'product_categories', 

              'as' => 'product_categories.edit', 

              'icon' => null, 

              'parent' => $manageProducts->id,

              'parent_show' => $manageProducts->id,

              'parent_original' => $manageProductCategories->id,

              'appear' => '0', 

              'ordering' => '0', ]);

        $destroyProductCategories = Permission::create([
            'name' => 'delete_products_categories ',

            'display_name' => 'حذف فئة ',

            'route' => 'product_categories/{product_categories}', 

            'module' => 'product_categories', 

            'as' => 'product_categories.delete',

            'icon' => null, 

            'parent' => $manageProducts->id, 

            'parent_show' => $manageProducts->id, 

            'parent_original' => $manageProductCategories->id, 

            'appear' => '0', 

            'ordering' => '0', ]);
            

        // PAGES

        $managePages = Permission::create([ 

          'name' => 'manage_pages',

          'display_name' => 'ادارة الصفحات',

          'route' => 'pages',

          'module' => 'pages',

          'as' => 'pages.index',

          'icon' => 'fas fa-file',

          'parent' => '0', 

          'parent_original' => '0', 

          'appear' => '1',

          'ordering' => '20', ]);

        $managePages->parent_show = $managePages->id; $managePages->save();

        $showPages = Permission::create([

             'name' => 'show_pages', 

             'display_name' => 'عرض الصفحات ', 

             'route' => 'pages', 

             'module' => 'pages', 

             'as' => 'pages.index', 

             'icon' => 'fas fa-file', 

             'parent' => $managePages->id, 

             'parent_show' => $managePages->id, 

             'parent_original' => $managePages->id, 

             'appear' => '0',

             'ordering' => '0', ]);

        $createPages = Permission::create([

            'name' => 'create_pages', 

            'display_name' => 'صفحة جديدة ', 

            'route' => 'pages/create', 

            'module' => 'pages', 

            'as' => 'pages.create', 

            'icon' => null,

            'parent' => $managePages->id,

            'parent_show' => $managePages->id,

            'parent_original' => $managePages->id, 

            'appear' => '0', 

            'ordering' => '0',]);

        $displayPages = Permission::create([

            'name' => 'display_pages',

            'display_name' => 'عرض الصفحة ', 

            'route' => 'pages/{pages}',

            'module' => 'pages',

            'as' => 'pages.show', 

            'icon' => null, 

            'parent' => $managePages->id, 

            'parent_show' => $managePages->id, 

            'parent_original' => $managePages->id, 

            'appear' => '0', 'ordering' => '0', ]);

        $updatePages = Permission::create([ 

            'name' => 'update_pages', 

            'display_name' => 'تحديث الصفحة ',

             'route' => 'pages/{pages}/edit', 

            'module' => 'pages',

            'as' => 'pages.edit',

            'icon' => null, 

            'parent' => $managePages->id, 

            'parent_show' => $managePages->id, 

            'parent_original' => $managePages->id, 

            'appear' => '0',

            'ordering' => '0', ]);

        $destroyPages = Permission::create([

            'name' => 'delete_pages',

            'display_name' => 'حذف الصفحة ', 

            'route' => 'pages/{pages}',

            'module' => 'pages',

            'as' => 'pages.delete',

            'icon' => null,

            'parent' => $managePages->id,

            'parent_show' => $managePages->id,

            'parent_original' => $managePages->id,

            'appear' => '0', 


            'ordering' => '0', ]);





//contact_us
        $manageContactUs = Permission::create([ 

            'name' => ' manage_contact_us',

            'display_name' => ' تواصل معنا',

            'route' => 'contact_us',

            'module' => 'contact_us',

            'as' => 'contact_us.index',

            'icon' => 'fas fa-envelope',

            'parent' => '0', 

            'parent_original' => '0',

            'appear' => '1',

            'ordering' => '20', ]);

        $manageContactUs->parent_show = $manageContactUs->id; $manageContactUs->save();

        $showContactUs = Permission::create([ 

            'name' =>  'show_contact_us',

            'display_name' => '  تواصل معنا  ', 

            'route' => 'contact_us', 

            'module' => 'contact_us',

            'as' => 'contact_us.index', 

            'icon' => 'fas fa-envelope',

            'parent' => $manageContactUs->id,

            'parent_show' => $manageContactUs->id,

            'parent_original' => $manageContactUs->id,

            'appear' => '0', 

            'ordering' => '0', ]);

        $displayContactUs = Permission::create([

            'name' => 'display_contact_us', 

            'display_name' => 'عرض الرسائل ',

            'route' => 'contact_us/{contact_us}', 

            'module' => 'contact_us', 

            'as' => 'contact_us.show', 

            'icon' => null,

            'parent' => $manageContactUs->id,

            'parent_show' => $manageContactUs->id,

            'parent_original' => $manageContactUs->id, 

            'appear' => '0',

            'ordering' => '0',]);

        $updateContactUs = Permission::create([ 
            'name' => 'update_contact_us', 

            'display_name' => 'تحديث الرسائل ',

            'route' => 'contact_us/{contact_us}/edit', 

            'module' => 'contact_us',

            'as' => 'contact_us.edit',

            'icon' => null,

            'parent' => $manageContactUs->id,

            'parent_show' => $manageContactUs->id,

            'parent_original' => $manageContactUs->id,

            'appear' => '0', 

            'ordering' => '0', ]);

        $destroyContactUs = Permission::create([ 
            'name' => 'delete_contact_us',

            'display_name' => 'حذف الرسائل ',

            'route' => 'contact_us/{contact_us}',

            'module' => 'contact_us', 

            'as' => 'contact_us.delete',

            'icon' => null,

            'parent' => $manageContactUs->id,

            'parent_show' => $manageContactUs->id, 

            'parent_original' => $manageContactUs->id, 

            'appear' => '0', 

            'ordering' => '0', ]);



        // USERS
        $manageUsers = Permission::create([

            'name' => 'manage_users',

            'display_name' => 'ادارة المستخدمين  ',

            'route' => 'users', 

            'module' => 'users', 

            'as' => 'users.index', 

            'icon' => 'fas fa-user',

            'parent' => '0',

            'parent_original' => '0', 

            'appear' => '1', 

            'ordering' => '20', ]);

        $manageUsers->parent_show = $manageUsers->id; $manageUsers->save();

        $showUsers = Permission::create([

            'name' => 'show_users',

            'display_name' => 'المستخدمين', 

            'route' => 'users', 

            'module' => 'users',

            'as' => 'users.index', 

            'icon' => 'fas fa-user', 

            'parent' => $manageUsers->id, 

            'parent_show' => $manageUsers->id, 

            'parent_original' => $manageUsers->id,

            'appear' => '1',
            
            'ordering' => '0', ]);

        $createUsers = Permission::create([ 

            'name' => 'create_users', 

            'display_name' => 'مستخدم جديد ',

            'route' => 'users/create',

            'module' => 'users',

            'as' => 'users.create',

            'icon' => null, 

            'parent' => $manageUsers->id,

            'parent_show' => $manageUsers->id, 

            'parent_original' => $manageUsers->id, 

            'appear' => '0', 

            'ordering' => '0',]);

        $displayUsers = Permission::create([

            'name' => 'display_users', 

            'display_name' => 'عرض المستخدم ',

            'route' => 'users/{users}',

            'module' => 'users', 

            'as' => 'users.show',

            'icon' => null, 

            'parent' => $manageUsers->id,

            'parent_show' => $manageUsers->id, 

            'parent_original' => $manageUsers->id,

            'appear' => '0', 

            'ordering' => '0',]);


        $updateUsers = Permission::create([

            'name' => 'update_users', 

            'display_name' => 'تحديث المستخدمين   ', 

            'route' => 'users/{users}/edit', 

            'module' => 'users', 

            'as' => 'users.edit',

            'icon' => null, 

            'parent' => $manageUsers->id,

            'parent_show' => $manageUsers->id,

            'parent_original' => $manageUsers->id,

            'appear' => '0', 

            'ordering' => '0', ]);

        $destroyUsers = Permission::create([ 

            'name' => 'delete_users', 

            'display_name' => ' حذف المشرفون',

            'route' => 'users/{users}', 

            'module' => 'users', 

            'as' => 'users.delete', 

            'icon' => null, 

            'parent' => $manageUsers->id,

            'parent_show' => $manageUsers->id, 

            'parent_original' => $manageUsers->id,

            'appear' => '0',

            'ordering' => '0', ]);


        // EDITORS
        // SUPERVISORS
        $manageSupervisors = Permission::create([
            'name' => 'manage_supervisors ',

            'display_name' => 'ادارة المشرفون',

            'route' => 'supervisor',

            'module' => 'supervisor',

            'as' => 'supervisor.index', 

            'icon' => 'fas fa-user-shield',

            'parent' => '0', 

            'parent_original' => '0', 

            'appear' => '1',

            'ordering' => '700',

            'sidebar_link' => '0']);

        $manageSupervisors->parent_show = $manageSupervisors->id; $manageSupervisors->save();

        $showSupervisors = Permission::create([ 

            'name' => 'show_supervisors', 

            'display_name' => 'عرض المشرفون', 

            'route' => 'supervisor',

            'module' => 'supervisor',

            'as' => 'supervisor.index', 

            'icon' => 'fas fa-user-shield', 

            'parent' => $manageSupervisors->id,

            'parent_show' => $manageSupervisors->id, 

            'parent_original' => $manageSupervisors->id,

            'appear' => '1', 

            'ordering' => '0', 

            'sidebar_link' => '0']);


        $createSupervisors = Permission::create([ 
            'name' => 'create_supervisors',
            'name' => 'مشرف جديد', 

            'display_name' => 'مشرف جديد ', 

            'route' => 'supervisor/create',

             'module' => 'supervisor', 

             'as' => 'supervisor.create', 

             'icon' => null, 

             'parent' => $manageSupervisors->id,

             'parent_show' => $manageSupervisors->id,

             'parent_original' => $manageSupervisors->id,

             'appear' => '0', 

             'ordering' => '0',

             'sidebar_link' => '0']);


        $displaySupervisors = Permission::create([ 

            'name' => 'display_supervisors',

            'display_name' => 'عرض المشرفون    ',

            'route' => 'supervisor/{supervisor}',

            'module' => 'supervisor', 

            'as' => 'supervisor.show', 

            'icon' => null, 

            'parent' => $manageSupervisors->id,

            'parent_show' => $manageSupervisors->id,

            'parent_original' => $manageSupervisors->id, 

            'appear' => '0', 

            'ordering' => '0', 

            'sidebar_link' => '0']);

        $updateSupervisors = Permission::create([
            
            'name' => 'update_supervisors',

            'display_name' => 'تحديث المشرفون ',

            'route' => 'supervisor/{supervisor}/edit',

            'module' => 'supervisor', 

            'as' => 'supervisor.edit',

            'icon' => null,

            'parent' => $manageSupervisors->id,

            'parent_show' => $manageSupervisors->id, 

            'parent_original' => $manageSupervisors->id,

            'appear' => '0', 

            'ordering' => '0',

            'sidebar_link' => '0']);

        $destroySupervisors = Permission::create([ 
            'name' => 'delete_supervisors', 

            'display_name' =>'حذف المشرف',

            'route' => 'supervisor/{supervisor}',

            'module' => 'supervisor',

            'as' => 'supervisor.delete', 

            'icon' => null, 

            'parent' => $manageSupervisors->id,

            'parent_show' => $manageSupervisors->id, 

            'parent_original' => $manageSupervisors->id, 

            'appear' => '0',

            'ordering' => '0',

            'sidebar_link' => '0']);

        // SETTINGS
        $manageSettings = Permission::create([
            'name' => 'manage_settings',

            'display_name' => 'ادارة الاعدادات ',

            'route' => 'settings',

            'module' => 'settings',

            'as' => 'settings.index',

            'icon' => 'fas fa-cog', 

            'parent' => '0', 

            'parent_original' => '0',

            'appear' => '0', 

            'ordering' => '600', 

            'sidebar_link' => '0']);

        $manageSettings->parent_show = $manageSettings->id; $manageSettings->save();

        $showSettings = Permission::create([

            'name' => 'show_settings',

            'display_name' => 'عرض الاعدادات',

            'route' => 'settings',

            'module' => 'settings',

            'as' => 'settings.index',

            'icon' => 'fas fa-cog',

            'parent' => $manageSettings->id,

            'parent_show' => $manageSettings->id, 

            'parent_original' => $manageSettings->id,

            'appear' => '1',

            'ordering' => '0',

            'sidebar_link' => '0']);

     

        $displaySettings = Permission::create([ 
            'name' => 'display_settings', 

            'display_name' => 'عرض الاعدادات', 

            'route' => 'settings/{settings}',

             'module' => 'settings', 

             'as' => 'settings.show', 

             'icon' => null, 

             'parent' => $manageSettings->id,

            'parent_show' => $manageSettings->id, 

            'parent_original' => $manageSettings->id, 

            'appear' => '0', 

            'ordering' => '0', 

            'sidebar_link' => '0']);

       
    
}

}

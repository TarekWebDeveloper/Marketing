<?php
use App\Models\Category;
use Illuminate\Database\Seeder;

class CategoriesTableSeeder extends Seeder
{
   /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        Category::create([ 'name' => ' عام ' ,            'status' => 1]);

        Category::create([ 'name' => 'تكنولوجيا',        'status' => 1]);

        Category::create([ 'name' => 'سيارات',            'status' => 1]);

        Category::create([ 'name' => 'عقارات',            'status' => 1]);

        Category::create([ 'name' => 'مفروشات  ',         'status' => 1]);

        Category::create([ 'name' => 'مأكولات',            'status' => 1]);



    }
}

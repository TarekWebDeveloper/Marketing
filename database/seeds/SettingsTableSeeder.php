<?php

use App\Models\Setting;
use Illuminate\Database\Seeder;

class SettingsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    { 
    Setting::create(['display_name' => 'اسم الموقع ', 
                     'key' => 'site_title',
                     'value' => 'شام ',
                     'type' => 'text',
                    'section' => 'general ',
                     'ordering' => 5]);

    Setting::create([ 'display_name' => 'الهدف من الموقع ',
                      'key' => 'site_description',
                      'value' => 'التسويق الالكتروني  ', 
                      'details' => null, 
                      'type' => 'text', 
                      'section' => 'general ', 
                      'ordering' => 6]);

    Setting::create([ 'display_name' =>'الايميل',
                      
                      'key' => 'site_email', 
                      'value' => 'shamShopping _2023@gmail.com',
                      
                       'details' => null, 
                       'type' => 'text',
                        'section' => 'general ', 
                        'ordering' => 7]);

    Setting::create([ 'display_name' => 'حالة الموقع  ', 
                      'key' => 'site_status',
                      'value' => 'فعال', 
                      'details' => null, 
                      'type' => 'text', 
                      'section' => 'general ', 
                      'ordering' => 8]);

    Setting::create([ 'display_name' => 'رقم للتواصل  ',
                     'key' => 'phone',
                     'value' => '0988888873',
                     'details' => null,
                     'type' => 'text',
                     'section' => 'general ', 
                     'ordering' => 9]);

    Setting::create([ 'display_name' =>'العنوان',
                      'key' => 'address',
                      'value' => 'سورية',
                     'details' => null, 
                     'type' => 'text', 
                     'section' => 'general ',
                      'ordering' => 10]);

   
    }}
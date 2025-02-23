<?php

use App\Models\Role;

use App\Models\User;

use Carbon\Carbon;

use Faker\Factory;

use Illuminate\Database\Seeder;



class RolesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()

    {


    // Factory



        $faker = Factory::create();

    //Roles

        $adminRole = Role::create([

            'name' => 'admin',

            'display_name' => 'Administrator',

            'description' => 'System Administrator', 

            'allowed_route' => 'admin']);




        $editorRole = Role::create([
            'name' => 'editor',

            'display_name' => 'Supervisor',

            'description' => 'System Supervisor', 

            'allowed_route' => 'admin']);



        $userRole = Role::create([
            'name' => 'user', 

            'display_name' => 'User',

            'description' => 'Normal User',

            'allowed_route' => null]);


        //create admin 

        $admin = User::create([
            'name' => 'Admin',

            'username' => 'admin',

            'email' => 'admin@sham.test',

            'mobile' => '0944406543',

            'email_verified_at' => Carbon::now(),

            'password' => bcrypt('123123123'),

            'status' => 1,
        ]);

        $admin->attachRole($adminRole);





        //create editor

        $editor = User::create([

            'name' => 'Editor',

            'username' => 'editor',

            'email' => 'editor@sham.test',

            'mobile' => '0988566674',

            'email_verified_at' => Carbon::now(),

            'password' => bcrypt('456456456'),

            'status' => 1,
        ]);
        $editor->attachRole($editorRole);






        //create user

        $user1 = User::create([

            'name' => 'Ali zaher', 

            'username' => 'ali', 

            'email' => 'ali@sham.test', 

            'mobile' => '0944404544',

            'email_verified_at' => Carbon::now(),

            'password' => bcrypt('789789789'),

            'status' => 1,]);

        $user1->attachRole($userRole);






        $user2 = User::create([
            'name' => 'Mhd Ali', 

            'username' => 'mhd', 

            'email' => 'mhd@sham.test', 

            'mobile' => '0988566651',

            'email_verified_at' => Carbon::now(), 

            'password' => bcrypt('1231231231'), 

            'status' => 1,]);

        $user2->attachRole($userRole);









        $user3 = User::create([

            'name' => 'Samer japany',

            'username' => 'samer', 

            'email' => 'Samer@sham.test',

            'mobile' => '0932453233',

            'email_verified_at' => Carbon::now(),

            'password' => bcrypt('2342342341'),

            'status' => 1,]);

        $user3->attachRole($userRole);






        

        for ($i = 0; $i <10; $i++) {
            $user = User::create([

                'name' => $faker->name,

                'username' => $faker->userName,

                'email' => $faker->email,

                'mobile' => '963' . random_int(10000000, 99999999),

                'email_verified_at' => Carbon::now(),

                'password' => bcrypt('987987987'),

                'status' => 1
            ]);
            $user->attachRole($userRole);
        }


    }
}

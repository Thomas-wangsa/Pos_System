<?php

use Illuminate\Database\Seeder;

use App\User;
use App\Http\Models\Category;
use Faker\Factory as Faker;

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run() {
        $faker = Faker::create();
        // $this->call(UsersTableSeeder::class);

        $users_array = array(
            array(
                "name"=>"superman",
                "email"=>"admin@gmail.com",
                "phone"=>$faker->phoneNumber,
                "uuid"=>$faker->uuid,
                "password"=>bcrypt(123456),
                "role"=>2,
                "created_by"=>null,
                "updated_by"=>null
            ),
            array(
                "name"=>$faker->name,
                "email"=>"sales1@gmail.com",
                "phone"=>$faker->phoneNumber,
                "uuid"=>$faker->uuid,
                "password"=>bcrypt(123456),
                "role"=>3,
                "created_by"=>null,
                "updated_by"=>null
            ),
            array(
                "name"=>$faker->name,
                "email"=>"sales12@gmail.com",
                "phone"=>$faker->phoneNumber,
                "uuid"=>$faker->uuid,
                "password"=>bcrypt(123456),
                "role"=>3,
                "created_by"=>null,
                "updated_by"=>null
            ),
        );


        foreach ($users_array as $key => $value) {
            User::firstOrCreate($value);       
        }

        $category_array = array(
            array(
                "name"=>"sofa",
                "detail"=>"sofaku",
                "created_by"=>1,
                "updated_by"=>1
            ),
            array(
                "name"=>"piring",
                "detail"=>"kasurku",
                "created_by"=>1,
                "updated_by"=>1
            )
        );

        foreach ($category_array as $key => $value) {
            Category::firstOrCreate($value);       
        }
    }
}

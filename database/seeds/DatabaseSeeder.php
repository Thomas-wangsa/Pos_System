<?php

use Illuminate\Database\Seeder;

use App\User;
use App\Http\Models\Category;
use App\Http\Models\Customer;
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
                "email"=>"sales2@gmail.com",
                "phone"=>$faker->phoneNumber,
                "uuid"=>$faker->uuid,
                "password"=>bcrypt(123456),
                "role"=>3,
                "created_by"=>null,
                "updated_by"=>null
            ),
            array(
                "name"=>$faker->name,
                "email"=>"sales3@gmail.com",
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



        $full_data = array();
        for($i=0;$i<=30;$i++) { 
            $customer_array = array(
                "category_id"=>$faker->numberBetween(1,2),
                "sales_id"=>$faker->numberBetween(2,4),
                "name"=>$faker->name,
                "phone"=>$faker->phoneNumber,
                "owner"=>$faker->name,
                "address"=>$faker->address,
                "note"=>$faker->text,
                "relation_at"=>$faker->date,
                "uuid"=>$faker->uuid,
                "created_by"=>1,
                "updated_by"=>1,
                "created_at"    => $faker->dateTime($max = 'now'),
                "updated_at"    => $faker->dateTime($max = 'now'),
            );

            array_push($full_data,$customer_array);

        }
        Customer::insert($full_data);
    }
}

<?php

use Illuminate\Database\Seeder;

use App\User;
use App\Http\Models\Category;

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run() {
        // $this->call(UsersTableSeeder::class);

        $users_array = array(
            array(
                "name"=>"superman",
                "email"=>"admin@gmail.com",
                // "name"=>"sir kat",
                // "email"=>"katimin@indosatooredoo.com",
                "uuid"=>"20190701qrnaonfsjnf-gsgsgs-tnlyhl",
                "password"=>bcrypt(123456),
                "created_by"=>null,
                "updated_by"=>null
            )
        );


        foreach ($users_array as $key => $value) {
            User::firstOrCreate($value);       
        }

        $category_array = array(
            array(
                "name"=>"sofa",
                "created_by"=>1,
                "updated_by"=>1
            ),
            array(
                "name"=>"piring",
                "created_by"=>1,
                "updated_by"=>1
            )
        );

        foreach ($category_array as $key => $value) {
            Category::firstOrCreate($value);       
        }
    }
}

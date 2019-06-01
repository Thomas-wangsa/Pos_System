<?php

use Illuminate\Database\Seeder;

use App\User;

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
                "password"=>bcrypt(123456),
            )
        );


        foreach ($users_array as $key => $value) {
            User::firstOrCreate($value);       
        }
    }
}

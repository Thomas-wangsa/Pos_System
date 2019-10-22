<?php

use Illuminate\Database\Seeder;

use App\User;
use App\Http\Models\UserRole;

use App\Http\Models\Category;
use App\Http\Models\Customer;
use App\Http\Models\PO;
use App\Http\Models\SubPO;

use App\Http\Models\Driver;

use App\Http\Models\PO_Status;
use App\Http\Models\Sub_PO_Status;
use App\Http\Models\Delivery_Order_Status;
use App\Http\Models\Invoice_Status;
use App\Http\Models\Customer_Status;

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


        $this->init();


        

        $users_array = array(
            array(
                "name"=>$faker->name,
                "email"=>"sales1@gmail.com",
                "phone"=>$faker->phoneNumber,
                "uuid"=>$faker->uuid,
                "password"=>bcrypt(123456),
                "role"=>3,
                "created_by"=>1,
                "updated_by"=>1
            ),
            array(
                "name"=>$faker->name,
                "email"=>"sales2@gmail.com",
                "phone"=>$faker->phoneNumber,
                "uuid"=>$faker->uuid,
                "password"=>bcrypt(123456),
                "role"=>3,
                "created_by"=>1,
                "updated_by"=>1
            ),
            array(
                "name"=>$faker->name,
                "email"=>"sales3@gmail.com",
                "phone"=>$faker->phoneNumber,
                "uuid"=>$faker->uuid,
                "password"=>bcrypt(123456),
                "role"=>3,
                "created_by"=>1,
                "updated_by"=>1
            ),
        );


        foreach ($users_array as $key => $value) {
            User::firstOrCreate($value);       
        }


        for($i=1;$i<=20;$i++){

            $data = array(
                "name"=>$faker->name,
                "email"=>$faker->email,
                "phone"=>$faker->phoneNumber,
                "uuid"=>$faker->uuid,
                "password"=>bcrypt(123456),
                "role"=>$faker->numberBetween(1,3),
                "created_by"=>1,
                "updated_by"=>1
            );
            User::firstOrCreate($data); 
        }

        $category_array = array(
            array(
                "name"=>"sofa",
                "detail"=>"sofaku",
                "created_by"=>1,
                "updated_by"=>1,
                "uuid"=>$faker->uuid
            ),
            array(
                "name"=>"kasur",
                "detail"=>"kasur",
                "created_by"=>1,
                "updated_by"=>1,
                "uuid"=>$faker->uuid
            ),
            array(
                "name"=>"piring",
                "detail"=>"piring",
                "created_by"=>1,
                "updated_by"=>1,
                "uuid"=>$faker->uuid
            )
        );

        foreach ($category_array as $key => $value) {
            Category::firstOrCreate($value);       
        }


        


        $full_data = array();
        for($i=0;$i<=5;$i++) { 
            $customer_array = array(
                "name"=>$faker->company,
                "phone"=>$faker->phoneNumber,
                "owner"=>$faker->name,
                "address"=>$faker->address,
                "note"=>$faker->text,
                "relation_at"=>$faker->date,
                "uuid"=>$faker->uuid,
                "sales_id"=>$faker->numberBetween(2,13),
                "created_by"=>1,
                "updated_by"=>1,
                "created_at"    => $faker->dateTime($max = 'now'),
                "updated_at"    => $faker->dateTime($max = 'now'),
            );

            array_push($full_data,$customer_array);

        }
        Customer::insert($full_data);

        $po_data = array();
        for($i=0;$i<15;$i++) { 
            
            $po = new PO;
            $po->customer_id = $faker->numberBetween(1,5);
            $po->sales_id = $faker->numberBetween(2,4);
            $po->category_id = $faker->numberBetween(1,3);
            $po->number = "00".$faker->randomDigitNotNull()."/".$faker->company;
            $po->note = $faker->text;
            $po->uuid = $faker->uuid;
            $po->created_by = 1;
            $po->updated_by = 1;
            $po->save();

            $sub_po_qty = $faker->numberBetween(1,10);

            $sub_po_data = array();
            for($j=0;$j<=$sub_po_qty;$j++) {
                $sub_po_array = array(
                "po_id"=>$po->id,
                "quantity"=>$faker->numberBetween(1,1000),
                "name"=>$faker->swiftBicNumber,
                "price"=>$faker->numberBetween(10000,1000000),
                "status"=>1,
                "note"=>$faker->text,
                "uuid"=>$faker->uuid,
                "created_by"=>1,
                "updated_by"=>1,
                );

                array_push($sub_po_data,$sub_po_array);
            }
            SubPO::insert($sub_po_data);
        }



        


        $driver_array = array(
            array(
                "name"=>"taufik",
                "detail"=>"B 9022",
                "created_by"=>1,
                "updated_by"=>1,
                "uuid"=>$faker->uuid
            ),
            array(
                "name"=>"syamsu",
                "detail"=>"B 9023",
                "created_by"=>1,
                "updated_by"=>1,
                "uuid"=>$faker->uuid
            ),
        );


        foreach ($driver_array as $key => $value) {
            Driver::firstOrCreate($value);       
        }


    }




    public function init() {
        $faker = Faker::create();


        $role_array = array(
            array('name'=>"owner"),
            array('name'=>"admin"),
            array('name'=>"sales")
        );

        foreach($role_array as $key => $value) {
            UserRole::firstOrCreate($value);       
        }


        $customer_status_array = array(
            array('name'=>"good","color"=>"blue"),
            array('name'=>"warning","color"=>"yellow"),
            array('name'=>"bad","color"=>"red"),
        );

        foreach($customer_status_array as $key => $value) {
            Customer_Status::firstOrCreate($value);       
        }



        $user = array(
                "name"=>"superman",
                "email"=>"admin@gmail.com",
                "phone"=>$faker->phoneNumber,
                "uuid"=>$faker->uuid,
                "password"=>bcrypt(123456),
                "role"=>1,
                "created_by"=>null,
                "updated_by"=>null
            );

        User::firstOrCreate($user); 



        $po_status_array = array(
            array(
                "name"=>"in-progress",
                "color"=>"black",
            ),
            array(
                "name"=>"cancel",
                "color"=>"red",
            ),
            array(
                "name"=>"success",
                "color"=>"blue",
            )
        );


        foreach ($po_status_array as $key => $value) {
            PO_Status::firstOrCreate($value); 
            Delivery_Order_Status::firstOrCreate($value);
        }



        $inv_status_array = array(
            array(
                "name"=>"in-progress",
                "color"=>"black",
            ),
            array(
                "name"=>"cancel",
                "color"=>"red",
            ),
            array(
            "name"=>"active",
            "color"=>"black"
            ),
            array(
                "name"=>"success",
                "color"=>"blue",
            )
        );

        foreach ($inv_status_array as $key => $value) {
            Invoice_Status::firstOrCreate($value);      
        }





        $sub_po_status_array = array(
            array(
                "name"=>"urgent",
                "color"=>"red",
            ),
            array(
                "name"=>"normal",
                "color"=>"black",
            ),
            array(
                "name"=>"low",
                "color"=>"gray",
            )
        );

        foreach ($sub_po_status_array as $key => $value) {
            Sub_PO_Status::firstOrCreate($value);     
        }



    }

}

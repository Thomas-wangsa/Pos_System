<?php

use Illuminate\Database\Seeder;

use App\User;
use App\Http\Models\Category;
use App\Http\Models\Customer;
use App\Http\Models\PO;
use App\Http\Models\SubPO;
use App\Http\Models\Driver;

use App\Http\Models\PO_Status;
use App\Http\Models\Delivery_Order_Status;

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
                "name"=>"kasur",
                "detail"=>"kasur",
                "created_by"=>1,
                "updated_by"=>1
            ),
            array(
                "name"=>"piring",
                "detail"=>"piring",
                "created_by"=>1,
                "updated_by"=>1
            )
        );

        foreach ($category_array as $key => $value) {
            Category::firstOrCreate($value);       
        }



        $full_data = array();
        for($i=0;$i<=15;$i++) { 
            $customer_array = array(
                "category_id"=>$faker->numberBetween(1,3),
                "sales_id"=>$faker->numberBetween(2,4),
                "name"=>$faker->company,
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

        $po_data = array();
        for($i=0;$i<15;$i++) { 
            
            $po = new PO;
            $po->customer_id = $faker->numberBetween(1,15);
            $po->sales_id = $faker->numberBetween(2,4);
            $po->number = "00".$faker->randomDigitNotNull()."/".$faker->company;
            $po->date = date("Y-m-d H:i:s");
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

                $sub_po_array["total"] = $sub_po_array["quantity"] * $sub_po_array["price"];
                array_push($sub_po_data,$sub_po_array);
            }
            SubPO::insert($sub_po_data);
        }



        $po_status_array = array(
            array(
                "name"=>"active",
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



        $driver_array = array(
            array(
                "name"=>"taufik",
                "detail"=>"B 9022",
                "created_by"=>1,
                "updated_by"=>1,
            ),
            array(
                "name"=>"syamsu",
                "detail"=>"B 9023",
                "created_by"=>1,
                "updated_by"=>1,
            ),
        );


        foreach ($driver_array as $key => $value) {
            Driver::firstOrCreate($value);       
        }


    }
}

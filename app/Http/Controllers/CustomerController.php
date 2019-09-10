<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;

use Illuminate\Http\Request;
use App\User;

use App\Http\Models\Category;
use App\Http\Models\Customer;
use Faker\Factory as Faker;
class CustomerController extends Controller
{   
    protected $faker;
    protected $redirectTo      = 'customer.index';

    public function __construct(){
        $this->faker    = Faker::create();

    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {   
        $customer = Customer::leftjoin('users','users.id','=','customer.sales_id')
                    ->select('customer.*','users.name AS sales_name')
                    ->get();
        // dd($customer);
        $data['customer'] = $customer;
        return view('customer/index',compact('data'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $sales = User::where('role',3)->get();
        $data['faker'] = $this->faker;
        $data['sales'] = $sales;
        return view('customer/create',compact('data'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {   
        $new_customer = new Customer;

        $new_customer->sales_id = $request->sales;
        $new_customer->name = $request->name;
        
        $new_customer->phone = $request->phone;
        $new_customer->owner = $request->owner;
        $new_customer->address = $request->address;
        $new_customer->relation_at = $request->relation_at;
        $new_customer->note = $request->note;

        $new_customer->uuid = time()."-".$this->faker->uuid;
        $new_customer->created_by = Auth::user()->id;
        $new_customer->updated_by = Auth::user()->id;
        $new_customer->save();
        return redirect()->route($this->redirectTo);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }


    public function get_customer_by_category_id(Request $request) {
        $response = ["error"=>True,"messages"=>NULL,"data"=>NULL];

        //trigger exception in a "try" block
        try {
            $category_id = $request->category_id;
            $data = Customer::where('category_id',$category_id)
                            ->select('uuid','name')->get();

            if(count($data) > 0) {
                $response['data'] = $data;
                $response['error'] = False;
                return json_encode($response);
            }

            $response['messages'] = "no data found!";
            return json_encode($response);
        }
        //catch exception
        catch(Exception $e) {
            $response['messages'] = $e->getMessage();
            return json_encode($response);
        }
    }   
} 

<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;

use Illuminate\Http\Request;
use App\User;

use App\Http\Models\Category;
use App\Http\Models\Customer;
use App\Http\Models\Customer_Status;

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
    public function index(Request $request)
    {   
        
        $allowed = false;
        $self_data = User::where('id',Auth::user()->id)->first();
        if($self_data == null) {
            $request->session()->flash('alert-danger', "self_data is not found!");
            return redirect()->route("home");
        }


        $role = $self_data->role;
        if($role == 1 OR $role == 2) {
            $allowed = true;
        }


        $sales = User::orderBy('name','asc')->withTrashed();
        if(!$allowed) {
            $sales = $sales->where('id','=', Auth::user()->id);
        }
        $sales = $sales->get();



        $customer_status = Customer_Status::all();
        $customer = Customer::leftjoin('users','users.id','=','customer.sales_id');



        if($request->search == "on") { 

            if($request->search_nama != null) { 
                $customer = $customer->where('customer.name','like',$request->search_nama."%");
            }


            if($request->search_sales != null) {
                $customer = $customer->where('customer.sales_id','=', $request->search_sales);
                
            }

            if($request->search_status != null) {
                if($request->search_status == "is_deleted") {
                    $customer =  Customer::onlyTrashed();
                    $customer = $customer->leftjoin('users','users.id','=','customer.sales_id');
                } else {
                    $customer = $customer->where('customer.status','=', $request->search_status);
                }
            }



            if($request->uuid != null) {
                $customer = $customer->where('customer.uuid','=',$request->uuid);
            }

        }


        if(!$allowed) {
            $customer = $customer->where('customer.sales_id','=', Auth::user()->id);
        }

        $customer = $customer->select('customer.*','users.name AS sales_name');

        if($request->search_order != null) {
                $customer = $customer->orderBy($request->search_order, 'asc');
        }


        $customer = $customer->paginate(20);
        // dd($customer);
        $data['customer'] = $customer;
        $data['sales'] = $sales;
        $data['customer_status'] = $customer_status;
        return view('customer/index',compact('data'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {   
        $allowed = false;
        $self_data = User::where('id',Auth::user()->id)->first();
        if($self_data == null) {
            $request->session()->flash('alert-danger', "self_data is not found!");
            return redirect()->route("home");
        }


        $role = $self_data->role;
        if($role == 1 OR $role == 2) {
            $allowed = true;
        }

        if(!$allowed) {
            $request->session()->flash('alert-danger', "only admin and owner is allowed!");
            return redirect()->route($this->redirectTo);
        }


        $sales = User::orderBy('name','asc')->get();
        $status = Customer_Status::all();

        $data['faker'] = $this->faker;
        $data['sales'] = $sales;
        $data['status'] = $status;
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

        try {
            $new_customer = new Customer;

            $new_customer->sales_id = $request->sales;
            $new_customer->name = $request->name;
            
            $new_customer->phone = $request->phone;
            $new_customer->owner = $request->owner;
            $new_customer->address = $request->address;
            $new_customer->relation_at = $request->relation_at;
            $new_customer->status = $request->status;
            $new_customer->note = $request->note;

            $new_customer->uuid = time()."-".$this->faker->uuid;
            $new_customer->created_by = Auth::user()->id;
            $new_customer->updated_by = Auth::user()->id;
            $new_customer->save();
            $request->session()->flash('alert-success', $new_customer->name.' has been created');
            return redirect()->route($this->redirectTo,"search=on&uuid=".$new_customer->uuid);
        }
        catch(Exception $e) {
            $request->session()->flash('alert-danger', $e->getMessage());
            return redirect()->route($this->redirectTo);
        }
        
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($uuid)
    {
        
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Request $request,$uuid)
    {   
        $allowed = false;
        $self_data = User::where('id',Auth::user()->id)->first();
        if($self_data == null) {
            $request->session()->flash('alert-danger', "self_data is not found!");
            return redirect()->route("home");
        }


        $role = $self_data->role;
        if($role == 1 OR $role == 2) {
            $allowed = true;
        }

        if(!$allowed) {
            $request->session()->flash('alert-danger', "only admin and owner is allowed!");
            return redirect()->route($this->redirectTo);
        }


        $sales = User::orderBy('name','asc')->get();
        $status = Customer_Status::all();
        $customer = Customer::where('uuid',$uuid)->first();

        if($customer == null) {
            $request->session()->flash('alert-danger', 'customer is not found!');
            return redirect()->route($this->redirectTo);
        }

        $data['customer'] = $customer;
        $data['sales'] = $sales;
        $data['status'] = $status;
        $data['faker'] = $this->faker;
        return view('customer/edit',compact('data'));
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
        $customer = Customer::where('uuid',$id)->first();
        if($customer==null) {
            $request->session()->flash('alert-danger', 'customer is not found!');
            return redirect()->route($this->redirectTo);
        }

        $customer->sales_id = $request->sales;
        $customer->name = $request->name;
        
        $customer->phone = $request->phone;
        $customer->owner = $request->owner;
        $customer->address = $request->address;
        $customer->relation_at = $request->relation_at;
        $customer->relation_end = $request->relation_end;
        $customer->status = $request->status;
        $customer->note = $request->note;

        $customer->updated_by = Auth::user()->id;
        $customer->save();
        $request->session()->flash('alert-success', $customer->name.' has been updated');
        return redirect()->route($this->redirectTo,"search=on&uuid=".$customer->uuid);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $response = ["error"=>True,"messages"=>NULL,"data"=>NULL];

        try {

            $customer = Customer::where('uuid',$id)->first()->delete();
  
            $response['error'] = false;
            return json_encode($response);
        } catch(Exception $e) {
            $response['messages'] = $e->getMessage();
            return json_encode($response);
        }
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


    public function get_customer_by_uuid(Request $request) {
        $response = ["error"=>True,"messages"=>NULL,"data"=>NULL];
        try {
            $data = Customer::leftjoin('users as sales','sales.id','=','customer.sales_id')
            ->leftjoin('users as cb','cb.id','=','customer.created_by')
            ->leftjoin('users as cu','cu.id','=','customer.updated_by')
            ->leftjoin('customer_status as cs','cs.id','=','customer.status')
            ->where('customer.uuid',$request->uuid)
            ->select('customer.*','sales.name AS sales_name','cb.name AS created_by_name','cu.name AS updated_by_name','cs.name AS status_name')
            ->first();

            if($data == null) {
                $response['messages'] = "no data customer found!";
                return json_encode($response);
            } else {
                $response['data'] = $data;
                $response['error'] = False;
                return json_encode($response);
            }

        }
        //catch exception
        catch(Exception $e) {
            $response['messages'] = $e->getMessage();
            return json_encode($response);
        }
    }


    public function get_customer_by_sales_id(Request $request) {
        $response = ["error"=>True,"messages"=>NULL,"data"=>NULL];
        try {
            $data = Customer::where('customer.sales_id',$request->sales_id)
            ->select('customer.*')
            ->get();

            if(count($data) < 1) {
                $response['messages'] = "no data customer found!";
                return json_encode($response);
            } else {
                $response['data'] = $data;
                $response['error'] = False;
                return json_encode($response);
            }

        }
        //catch exception
        catch(Exception $e) {
            $response['messages'] = $e->getMessage();
            return json_encode($response);
        }
    }


    public function restore_customer_by_uuid(Request $request) {
        $response = ["error"=>True,"messages"=>NULL,"data"=>NULL];

        try{
            $data = Customer::withTrashed()->where('uuid',$request->uuid)->restore();

            if($data) {
                $response['data'] = $data;
                $response['error'] = False;
                return json_encode($response);
            }

        }
        //catch exception
        catch(Exception $e) {
            $response['messages'] = $e->getMessage();
            return json_encode($response);
        }
    }   
} 

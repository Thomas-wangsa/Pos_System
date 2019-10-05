<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Models\Category;
use App\Http\Models\Customer;
use App\Http\Models\PO;
use App\Http\Models\SubPO;
use App\Http\Models\Delivery_Order;
use App\Http\Models\Invoice;
use App\Http\Models\Invoice_Status;

use Faker\Factory as Faker;
use Illuminate\Support\Facades\Auth;

class POController extends Controller
{   
    protected $faker;
    protected $redirectTo      = 'po.index';
    protected $po_label        = 'the-brothers';

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
        //$customer = Customer::all();
        
        $po = PO::leftjoin('customer','po.customer_id','=','customer.id')
            ->leftjoin('users','po.sales_id','=','users.id')
            ->leftjoin('po_status','po.status','=','po_status.id')
            ->select('po.*','customer.name AS customer_name','users.name AS sales_name','po_status.name AS status_name')
            ->get();

        $customer = Customer::all();


        foreach($po as $key=>$val) {
            $po[$key]["total"] = 0;

            $sub_po_data = SubPO::where('po_id',$val->id)->get();

            if(count($sub_po_data) > 0) {
                $sub_po_data_total = 0;
                foreach($sub_po_data as $sub_po_key=>$sub_po_val) {
                    $sub_po_data_total += $sub_po_val["quantity"] * $sub_po_val["price"];
                }
                $po[$key]["total"] = $sub_po_data_total;
            }

            
        }
        
        //$data['customer'] = $customer;
        $data['po'] = $po;
        $data['customer'] = $customer;
        return view('po/index',compact('data'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {   
        try {
            $category = Category::all();
            $customer = Customer::leftjoin('users','users.id','=','customer.sales_id')
                    ->where('customer.uuid',$request->customer_uuid)
                    ->select('customer.*','users.name AS sales_name')
                    ->first();

            if($customer == null) {
                $request->session()->flash('alert-danger', 'customer is not found!');
                return redirect()->route($this->redirectTo);
            }

            $current_last_po_id = PO::orderBy('id','desc')->limit(1)->value('id');
            $next_id = 1;
            if($current_last_po_id != null) {
                $next_id += $current_last_po_id;
            }

            $patern_po_name = $next_id."/".$this->po_label."/".date("Y");

            $data['customer'] = $customer;
            $data['category'] = $category;
            $data['patern_po_name'] = $patern_po_name;
            return view('po/create',compact('data')); 
        }
        catch(Exception $e) {
            $request->session()->flash('alert-danger', $e->getMessage());
            return redirect()->route($this->redirectTo);
        }
        
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
            $customer = Customer::where('uuid',$request->customer_uuid)->first();
            if($customer == null) {
                $request->session()->flash('alert-danger', 'customer is not found!');
                return redirect()->route($this->redirectTo);
            }

            $exits = PO::where('number',$request->po_name)->first();
            if($exits) {
                $request->session()->flash('alert-danger',"create new PO failed : ". $request->po_name." already exits");
                return redirect()->route($this->redirectTo);
            }

            $po = new PO;
            $po->number = $request->po_name;
            $po->customer_id = $customer->id;
            $po->sales_id = $customer->sales_id;
            $po->category_id = $request->po_category;
            $po->note = $request->po_note;
            $po->uuid = $customer->id."-".time()."-".$this->faker->uuid;
            $po->created_by = Auth::user()->id;
            $po->updated_by = Auth::user()->id;
            $po->save();

            $request->session()->flash('alert-success', 'PO : '. $po->number.' has been created');
            return redirect()->route($this->redirectTo,"search=on&uuid=".$po->uuid);
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


    public function get_po_by_customer_uuid(Request $request) {
        $response = ["error"=>True,"messages"=>NULL,"data"=>NULL];

        //trigger exception in a "try" block
        try {
            $data = PO::join('customer','customer.id','=','po.customer_id')
                            ->where('customer.uuid',$request->customer_uuid)
                            ->select('po.uuid','po.number')->get();

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

    public function get_po_by_uuid(Request $request) {
        $response = ["error"=>True,"messages"=>NULL,"data"=>NULL];

        //trigger exception in a "try" block
        try {
            $data["po"] = PO::leftjoin('customer','customer.id','=','po.customer_id')
                    ->leftjoin('users','users.id','=','po.sales_id')
                    ->leftjoin('po_status','po_status.id','=','po.status')
                    ->leftjoin('users as c_user','c_user.id','=','po.created_by')
                    ->leftjoin('users as u_user','u_user.id','=','po.updated_by')
                    ->where('po.uuid',$request->uuid)
                    ->select(
                        'po.*',
                        'customer.name AS customer_name',
                        'users.name AS sales_name',
                        'po_status.name AS status_name',
                        'c_user.name AS created_by_name',
                        'u_user.name AS updated_by_name'
                    )
                    ->first();


            if($data['po'] == null) {
                $response['messages'] = "no data po found!";
                return json_encode($response);
            }


            // $data["sub_po"] = SubPO::where('po_id',$data['po']->id)->get();

            // if(count($data['sub_po']) < 1) {
            //     $response['messages'] = "no detail po found!";
            //     return json_encode($response);
            // }


            // $data["delivery_order"] = Delivery_Order::leftjoin('delivery_order_status',
            //     'delivery_order_status.id','=','delivery_order.status')
            //     ->where('delivery_order.po_id',$data['po']->id)
            //     ->select('delivery_order.*','delivery_order_status.name AS status_name')
            //     ->get();

            // $data["invoice"] = Invoice::leftjoin('invoice_status',
            //     'invoice_status.id','=','invoice.status')
            //     ->where('invoice.po_id',$data['po']->id)
            //     ->select('invoice.*','invoice_status.name AS status_name')
            //     ->get();


            // if(count($data) > 0) {
            //     $response['data'] = $data;
            //     $response['error'] = False;
            //     return json_encode($response);
            // }

            $response['data'] = $data;
            $response['error'] = False;
            return json_encode($response);
        }
        //catch exception
        catch(Exception $e) {
            $response['messages'] = $e->getMessage();
            return json_encode($response);
        }
    } 


    public function submit_po_by_customer_uuid(Request $request) {
        $response = ["error"=>True,"messages"=>NULL,"data"=>NULL];

        try {

            $customer = Customer::where('uuid',$request->customer_uuid)->first();
            if($customer == null) {
                $response['messages'] = "customer is not found!";
                return json_encode($response);
            }

            $exits = PO::where('number',$request->po_name)->first();
            if($exits) {
                $response['messages'] = "create new PO failed : ". $request->po_name." already exits";
                return json_encode($response);
            }

            $po_category = Category::where('id',$request->po_category)->first();
            if($po_category == null) {
                $response['messages'] = "category is not found!";
                return json_encode($response);
            }

            $po = new PO;
            $po->number = $request->po_name;
            $po->customer_id = $customer->id;
            $po->sales_id = $customer->sales_id;
            $po->category_id = $request->po_category;
            $po->note = $request->po_note;
            $po->uuid = $customer->id."-".time()."-".$this->faker->uuid;
            $po->created_by = Auth::user()->id;
            $po->updated_by = Auth::user()->id;
            $po->save();

            $response['error'] = false;
            $response['data'] = $po;
            return json_encode($response);
        }
        //catch exception
        catch(Exception $e) {
            $response['messages'] = $e->getMessage();
            return json_encode($response);
        }
    }
}

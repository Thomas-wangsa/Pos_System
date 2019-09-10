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
            $po[$key]["total"] = SubPO::where('po_id',$val->id)->sum('total');
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
        $category = Category::all();
        $customer = Customer::where('uuid',$request->customer_uuid)->first();


        $data['customer'] = $customer;
        $data['category'] = $category;
        //dd($customer);
        return view('po/create',compact('data')); 
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {   
        $response = ["error"=>True,"messages"=>NULL,"data"=>NULL];
        $customer = Customer::where('uuid',$request->customer_uuid)->first();

        $po = new PO;
        $po->customer_id = $customer->id;
        $po->sales_id = $customer->sales_id;
        $po->number = $request->po['po_name'];
        $po->date = $request->po['po_date'];
        $po->note = $request->po['po_note'];
        $po->uuid = $customer->id."-".time()."-".$this->faker->uuid;
        $po->created_by = Auth::user()->id;
        $po->updated_by = Auth::user()->id;
        $po->save();
        // return view('po/create',compact('data')); 
        // dd($request->subData);

        $full_data = array();
        for($i=0;$i<count($request->subData);$i++) { 
            $sub_po_array = array(
                "po_id"=>$po->id,
                "quantity"=>$request->subData[$i]['quantity'],
                "name"=>$request->subData[$i]['name'],
                "price"=>$request->subData[$i]['price'],
                "total"=>$request->subData[$i]['price'] * $request->subData[$i]['quantity'],
                "status"=>$request->subData[$i]['status'],
                "note"=>$request->subData[$i]['note'],
                "uuid"=>$po->id."-".time()."-".$this->faker->uuid,
                "created_by"=>Auth::user()->id,
                "updated_by"=>Auth::user()->id,
                "created_at"=>date("Y-m-d H:i:s"),
                "updated_at"=>date("Y-m-d H:i:s"), 
            );

            array_push($full_data,$sub_po_array);

        }
        SubPO::insert($full_data);

        $response['error'] = false;
        return json_encode($response);
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


            $data["sub_po"] = SubPO::where('po_id',$data['po']->id)->get();

            if(count($data['sub_po']) < 1) {
                $response['messages'] = "no detail po found!";
                return json_encode($response);
            }


            $data["delivery_order"] = Delivery_Order::leftjoin('delivery_order_status',
                'delivery_order_status.id','=','delivery_order.status')
                ->where('delivery_order.po_id',$data['po']->id)
                ->select('delivery_order.*','delivery_order_status.name AS status_name')
                ->get();

            $data["invoice"] = Invoice::leftjoin('invoice_status',
                'invoice_status.id','=','invoice.status')
                ->where('invoice.po_id',$data['po']->id)
                ->select('invoice.*','invoice_status.name AS status_name')
                ->get();

            // if(count($data["invoice"]) > 0 ) {
            //     foreach($data["invoice"] as $key=>$val) {
                    
            //     }
            // }


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

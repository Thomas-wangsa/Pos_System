<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Models\Category;
use App\Http\Models\Customer;

use App\Http\Models\PO;
use App\Http\Models\SubPO;
use App\Http\Models\Driver;

use App\Http\Models\Delivery_Order;
use App\Http\Models\Sub_Delivery_Order;

use App\Http\Models\Invoice;
use App\Http\Models\Sub_Invoice;

use Faker\Factory as Faker;
use Illuminate\Support\Facades\Auth;
class DOController extends Controller
{   
    protected $faker;
    protected $redirectTo      = 'do.index';

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
        // $category = Category::all();
        // $data['category'] = $category;
        // $data['do'] = Delivery_Order::leftjoin('po','po.id','=','delivery_order.po_id')
        //             ->leftjoin('driver','driver.id','=','delivery_order.driver_id')
        //             ->leftjoin('delivery_order_status','delivery_order_status.id','=','delivery_order.status')
        //             ->select('delivery_order.*','po.number AS po_number','driver.name AS driver_name','delivery_order_status.name AS status_name')
        //             ->get();
        //$data['customer'] = $customer;
        //dd($data);
        $data['do'] = Delivery_Order::all();
        return view('do/index',compact('data'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {   
        // $po = PO::where('uuid',$request->po_uuid)->first();


        // $sub_po = SubPO::where('po_id',$po->id)->get();
        // $data['po'] = $po;
        // $data['sub_po'] = $sub_po;
        // $data['do'] = Delivery_Order::all();
        $data['driver'] = Driver::all();
        $data['customer'] = Customer::orderBy('name','asc')->get();
        // //dd($data);

        return view('do/create',compact('data'));
    }


    public function store(Request $request) {
        $response = ["error"=>True,"messages"=>NULL,"data"=>NULL];

        try {
            $driver = Driver::find($request->driver_id);
            if($driver == null) {
                $response['messages'] = "driver data is not found!";
                return json_encode($response);
            } 

            $po = PO::where('uuid',$request->po_uuid)->first();
            if($po == null) {
                $response['messages'] = "po data is not found!";
                return json_encode($response);
            } 

            $sub_po_array = [];
            foreach($request->sub_data as $key=>$val) {
                if($val['active'] == 1) {array_push($sub_po_array,$val);}

            }

            if(count($sub_po_array) < 1) {
                $response['messages'] = "active sub po data is not found!";
                return json_encode($response);
            }

            foreach($sub_po_array as $key=>$val) {
                $sub_po = SubPO::where('po_id',$po->id)
                        ->where('uuid',$val['sub_po_uuid']."a")
                        ->first();
                if($sub_po == null) {
                    $response['messages'] = "sub po data is not found! : " . $val['sub_po_uuid'];
                    return json_encode($response);
                }
            }


        } catch(Exception $e) {
            $response['messages'] = $e->getMessage();
            return json_encode($response);
        }
        
    }
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store_bck(Request $request)
    {

        $response = ["error"=>True,"messages"=>NULL,"data"=>NULL];
        $po = PO::where('uuid',$request->po_uuid)->first();

        $do = new Delivery_Order;
        $do->po_id = $po->id;
        $do->driver_id = $request->delivery_order['driver_id'];
        $do->number = $request->delivery_order['do_name'];
        $do->date = $request->delivery_order['do_date'];
        $do->note = $request->delivery_order['do_note'];
        $do->uuid = $po->id."-".time()."-".$this->faker->uuid;
        $do->created_by = Auth::user()->id;
        $do->updated_by = Auth::user()->id;
        $do->save();


        $invoice = new Invoice;
        $invoice->po_id = $po->id;
        $invoice->sales_id = $po->sales_id;
        $invoice->number = $request->delivery_order['do_name'];
        $invoice->date = $request->delivery_order['do_date'];
        $invoice->note = $request->delivery_order['do_note'];
        $invoice->uuid = $po->id."-".time()."-".$this->faker->uuid;
        $invoice->created_by = Auth::user()->id;
        $invoice->updated_by = Auth::user()->id;
        $invoice->save();


        $full_data_delivery = array();
        $full_data_invoice  = array();
        for($i=0;$i<count($request->subData);$i++) { 
            $total = 0;
            $sub_po_array = array(
                "delivery_order_id"=>$do->id,
                "quantity"=>$request->subData[$i]['quantity'],
                "name"=>$request->subData[$i]['name'],
                "note"=>$request->subData[$i]['note'],
                "uuid"=>$do->id."-".time()."-".$this->faker->uuid,
                "created_by"=>Auth::user()->id,
                "updated_by"=>Auth::user()->id,
                "created_at"=>date("Y-m-d H:i:s"),
                "updated_at"=>date("Y-m-d H:i:s"), 
            );

            $sub_po_data = SubPO::where('po_id',$po->id)
                        ->where('name',$request->subData[$i]['name'])
                        ->first();
            $sub_invoice_array = array(
                "invoice_id"=>$invoice->id,
                "quantity"=>$request->subData[$i]['quantity'],
                "name"=>$request->subData[$i]['name'],
                "price"=>$sub_po_data->price,
                "total"=>$request->subData[$i]['quantity'] * $sub_po_data->price,
                "note"=>$request->subData[$i]['note'],
                "uuid"=>$do->id."-".time()."-".$this->faker->uuid,
                "created_by"=>Auth::user()->id,
                "updated_by"=>Auth::user()->id,
                "created_at"=>date("Y-m-d H:i:s"),
                "updated_at"=>date("Y-m-d H:i:s"), 
            );
            array_push($full_data_delivery,$sub_po_array);
            array_push($full_data_invoice,$sub_invoice_array);

        }
        Sub_Delivery_Order::insert($full_data_delivery);
        Sub_Invoice::insert($full_data_invoice);
        
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


    public function get_do_by_uuid(Request $request) {
        $response = ["error"=>True,"messages"=>NULL,"data"=>NULL];

        try {

            $data["delivery_order"] = Delivery_Order::leftjoin('po','po.id','=','delivery_order.po_id')
                    ->leftjoin('driver','driver.id','=','delivery_order.driver_id')
                    ->leftjoin('delivery_order_status','delivery_order_status.id','=','delivery_order.status')
                    ->leftjoin('users as c_user','c_user.id','=','delivery_order.created_by')
                    ->leftjoin('users as u_user','u_user.id','=','delivery_order.updated_by')
                    ->where('delivery_order.uuid',$request->uuid)
                    ->select(
                        'delivery_order.*',
                        'po.number AS po_number',
                        'driver.name AS driver_name',
                        'delivery_order_status.name AS status_name',
                        'c_user.name AS created_by_name',
                        'u_user.name AS updated_by_name'
                    )
                    ->first();


            if($data['delivery_order'] == null) {
                $response['messages'] = "no data delivery_order found!";
                return json_encode($response);
            }


            $data["sub_delivery_order"] = Sub_Delivery_Order::where('delivery_order_id',$data['delivery_order']->id)->get();

            if(count($data['sub_delivery_order']) < 1) {
                $response['messages'] = "no detail delivery order found!";
                return json_encode($response);
            }


            if(count($data) > 0) {
                $response['data'] = $data;
                $response['error'] = False;
                return json_encode($response);
            }

            $response['messages'] = "no data found!";
            return json_encode($response);

        }//catch exception
        catch(Exception $e) {
            $response['messages'] = $e->getMessage();
            return json_encode($response);
        }
    }
}

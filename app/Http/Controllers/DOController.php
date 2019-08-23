<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Models\Category;
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
        $category = Category::all();
        $data['category'] = $category;
        $data['do'] = Delivery_Order::leftjoin('po','po.id','=','delivery_order.po_id')
                    ->leftjoin('driver','driver.id','=','delivery_order.driver_id')
                    ->leftjoin('delivery_order_status','delivery_order_status.id','=','delivery_order.status')
                    ->select('delivery_order.*','po.number AS po_number','driver.name AS driver_name','delivery_order_status.name AS status_name')
                    ->get();
        //$data['customer'] = $customer;
        //dd($data);
        return view('do/index',compact('data'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {   
        $po = PO::where('uuid',$request->po_uuid)->first();


        $sub_po = SubPO::where('po_id',$po->id)->get();
        //$customer = Customer::all();
        $data['po'] = $po;
        $data['sub_po'] = $sub_po;
        $data['do'] = Delivery_Order::all();
        $data['driver'] = Driver::all();
        //$data['customer'] = $customer;
        //dd($data);
        return view('do/create',compact('data'));
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
        $grand_total = 0;
        for($i=0;$i<count($request->subData);$i++) { 
            $total = 0;
            $sub_po_array = array(
                "delivery_order_id"=>$do->id,
                "quantity"=>$request->subData[$i]['quantity'],
                "name"=>$request->subData[$i]['name'],
                "status"=>$request->subData[$i]['status'],
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
                "status"=>$request->subData[$i]['status'],
                "note"=>$request->subData[$i]['note'],
                "uuid"=>$do->id."-".time()."-".$this->faker->uuid,
                "created_by"=>Auth::user()->id,
                "updated_by"=>Auth::user()->id,
                "created_at"=>date("Y-m-d H:i:s"),
                "updated_at"=>date("Y-m-d H:i:s"), 
            );
            $total = $sub_invoice_array["quantity"] * $sub_invoice_array["price"];
            $grand_total += $total;
            array_push($full_data_delivery,$sub_po_array);
            array_push($full_data_invoice,$sub_invoice_array);

        }
        Sub_Delivery_Order::insert($full_data_delivery);
        Sub_Invoice::insert($full_data_invoice);
        $invoice->total = $grand_total;
        $invoice->save();
        
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
}

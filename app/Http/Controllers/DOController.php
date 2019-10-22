<?php

namespace App\Http\Controllers;
use DB;
use App\User;

use Illuminate\Http\Request;
use App\Http\Models\Category;
use App\Http\Models\Customer;

use App\Http\Models\PO;
use App\Http\Models\SubPO;
use App\Http\Models\Driver;

use App\Http\Models\Delivery_Order;
use App\Http\Models\Delivery_Order_Status;
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
    public function index(Request $request)
    {
        //$customer = Customer::all();
        // $category = Category::all();
        // $data['category'] = $category;
        $do = Delivery_Order::leftjoin('po','po.id','=','delivery_order.po_id')
                    ->leftjoin('customer','customer.id','=','delivery_order.customer_id')
                    ->leftjoin('users','users.id','=','po.sales_id')
                    ->leftjoin('driver','driver.id','=','delivery_order.driver_id')
                    ->leftjoin('delivery_order_status','delivery_order_status.id','=','delivery_order.status');


        if($request->search == "on") { 

            if($request->search_nama != null) { 
                $do = $do->where('delivery_order.number','like',$request->search_nama."%");
            }

            if($request->search_customer != null) {
                $do = $do->where('delivery_order.customer_id','=', $request->search_customer);
                
            }

            if($request->search_po != null) {
                $do = $do->where('delivery_order.po_id','=', $request->search_po);
                
            }

            if($request->search_status != null) {
                $do = $do->where('delivery_order.status','=', $request->search_status);
            }



            if($request->uuid != null) {
                $do = $do->where('delivery_order.uuid','=',$request->uuid);
            }

        }


        $do = $do->select(
                'delivery_order.*',
                'po.number AS po_number',
                'customer.name AS customer_name',
                'users.name AS sales_name',
                'driver.name AS driver_name',
                'delivery_order_status.name AS status_name')
            ->orderBy('number','desc');


        $do = $do->paginate(3);
        $data['po'] = PO::orderBy('number','asc')->withTrashed()->where('status',1)->get();
        $data['customer'] = Customer::orderBy('name','asc')->withTrashed()->get();
        $data['delivery_order_status'] = Delivery_Order_Status::all();
        //dd($data);
        $data['do'] = $do;
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


            $sub_delivery_order_data = [];
            foreach($sub_po_array as $key=>$val) {
                $sub_po = SubPO::where('po_id',$po->id)
                        ->where('uuid',$val['sub_po_uuid'])
                        ->first();
                if($sub_po == null) {
                    $response['messages'] = "sub po data is not found! : " . $val['sub_po_uuid'];
                    return json_encode($response);
                }

                $sub_delivery_order_each = [
                    "quantity"=>$val['quantity'],
                    "name"=>$sub_po->name,
                    // "delivery_order_id"=> $do->id,
                    "created_by"=> Auth::user()->id,
                    "updated_by"=>Auth::user()->id,
                    "uuid"=>$po->id."-".time()."-".$this->faker->uuid,
                    "created_at"=>date("Y-m-d H:i:s"),
                    "updated_at"=>date("Y-m-d H:i:s"),
                ];
                array_push($sub_delivery_order_data,$sub_delivery_order_each);
            }


            if(count($sub_delivery_order_data) < 1) {
                $response['messages'] = "sub_delivery_order_data is not found!";
                return json_encode($response);
            }



            $do = new Delivery_Order;
            $do->number = $this->set_patern_do_number($po);
            $do->driver_id = $driver->id;
            $do->po_id = $po->id;
            $do->customer_id = $po->customer_id;
            $do->sales_id = $po->sales_id;
            $do->created_by = Auth::user()->id;
            $do->updated_by = Auth::user()->id;
            $do->uuid = $po->id."-".time()."-".$this->faker->uuid;


            $inv = new Invoice;
            $inv->number = $this->set_patern_do_number($po);
            $inv->po_id = $po->id;
            $inv->customer_id = $po->customer_id;
            $inv->sales_id = $po->sales_id;
            $inv->created_by = Auth::user()->id;
            $inv->updated_by = Auth::user()->id;
            $inv->uuid = $po->id."-".time()."-".$this->faker->uuid;


            DB::transaction(function() use ($do,$inv, $sub_delivery_order_data) {
                $do->save();

                $inv->delivery_order_id = $do->id;

                foreach($sub_delivery_order_data as $key=>$val) {
                    $sub_delivery_order_data[$key]['delivery_order_id'] = $do->id;
                }
                
                Sub_Delivery_Order::insert($sub_delivery_order_data);

            });

            $response['error'] = false;
            $response['data'] = $do;
            return json_encode($response);

            

        } catch(Exception $e) {
            $response['messages'] = $e->getMessage();
            return json_encode($response);
        }
        
    }


    private function set_patern_do_number($po) {
        $current_last_do_id = Delivery_Order::orderBy('id','desc')->limit(1)->value('id');
        $next_id = 1;
        if($current_last_do_id != null) {
            $next_id += $current_last_do_id;
        }

        return $this->set_patern_digit($next_id)."/".$this->set_patern_digit($po->customer_id)."/".$this->set_patern_month()."/".date("Y");
    }

    private function set_patern_digit($data) {
        $length = strlen($data);
        $response = "000000".$data;

        switch($length) {
            case "1": $response = "0000".$data; break;
            case "2": $response = "000".$data; break;
            case "3": $response = "00".$data; break;
            case "4": $response = "0".$data; break;
            case "5": $response = "$data"; break;
            default : $response = "000000".$data;break;
        }
        return $response;
    }

    private function set_patern_month() {
        $m = date("m");

        $response = "XXX";

        switch($m) {
            case "1": $response = "I"; break;
            case "2": $response = "II"; break;
            case "3": $response = "III"; break;
            case "4": $response = "IV"; break;
            case "5": $response = "V"; break;
            case "6": $response = "VI"; break;
            case "7": $response = "VII"; break;
            case "8": $response = "VIII"; break;
            case "9": $response = "IX"; break;
            case "10": $response = "X"; break;
            case "11": $response = "XI"; break;
            case "12": $response = "XII"; break;
            default : $response = "XXX";;break;
        }
        return $response;
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


    public function edit_status_do(Request $request) {
        try {
            $do = Delivery_Order::where('uuid',$request->do_uuid)->first();
            if($do == null) {
                $request->session()->flash('alert-danger', 'do is not found!');
                return redirect()->route($this->redirectTo);
            }


            $do_status = Delivery_Order_Status::find($request->status);
            if($do_status == null) {
                $request->session()->flash('alert-danger', 'delivery order status is not found!');
                return redirect()->route($this->redirectTo);
            }


            $do->status = $do_status->id;
            $do->updated_by = Auth::user()->id;
            $do->save();

            $request->session()->flash('alert-success', 'DO : '. $do->number.' has been updated');
            return redirect()->route($this->redirectTo,"search=on&uuid=".$do->uuid);
        }
        catch(Exception $e) {
            $request->session()->flash('alert-danger', $e->getMessage());
            return redirect()->route($this->redirectTo);
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $do = Delivery_Order::leftjoin('customer','customer.id','=','delivery_order.po_id')
            ->leftjoin('po','po.id','=','delivery_order.po_id')
            ->leftjoin('users','users.id','=','delivery_order.sales_id')
            ->where('delivery_order.uuid',$id)
            ->select('delivery_order.*','customer.name AS customer_name','po.number AS po_number','users.name AS sales_name')
            ->first();

        if($do == null) {
            $request->session()->flash('alert-danger', 'do is not found!');
            return redirect()->route($this->redirectTo);
        }

        $po = PO::find($do->po_id);
        if($po == null) {
            $request->session()->flash('alert-danger', 'po is not found!');
            return redirect()->route($this->redirectTo);
        }

        $sub_po = SubPO::where('po_id',$po->id)->get();

        $data = array(
            'do'=>$do,
            'sub_po'=>$sub_po,
            'sub_do'=>Sub_Delivery_Order::where('delivery_order_id',$do->id)->withTrashed()->get(),
            'driver'=>Driver::all()
        );

        return view('do/edit',compact('data'));


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
        $do = Delivery_Order::where('uuid',$id)->first();

        if($do == null) {
            $request->session()->flash('alert-danger', 'do is not found!');
            return redirect()->route($this->redirectTo);
        }

        $do->driver_id = $request->do_driver;
        $do->save();
        $request->session()->flash('alert-success', $do->number.' has been updated');
        return redirect()->route($this->redirectTo,"search=on&uuid=".$do->uuid);
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

            $sub_po = Sub_Delivery_Order::where('uuid',$id)->first();
            if($sub_po == null) {
                $response['messages'] = "item is not found!";
                return json_encode($response);
            }

            $sub_po->delete();
            $response['error'] = false;
            return json_encode($response);
        } catch(Exception $e) {
            $response['messages'] = $e->getMessage();
            return json_encode($response);
        }
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


            //$data['sub_delivery_order'] = array();

            $data["sub_delivery_order"] = Sub_Delivery_Order::where('delivery_order_id',$data['delivery_order']->id)->get();

            $response['error'] = False;
            $response['data'] = $data;
            return json_encode($response);

            // 

            // if(count($data['sub_delivery_order']) < 1) {
            //     $response['messages'] = "no detail delivery order found!";
            //     return json_encode($response);
            // }


            // if(count($data) > 0) {
            //     $response['data'] = $data;
            //     $response['error'] = False;
            //     return json_encode($response);
            // }

            // $response['messages'] = "no data found!";
            // return json_encode($response);

        }//catch exception
        catch(Exception $e) {
            $response['messages'] = $e->getMessage();
            return json_encode($response);
        }
    }


    function update_sub_do_by_uuid(Request $request) {
        $response = ["error"=>True,"messages"=>NULL,"data"=>NULL];


        try {

            $sub_do = Sub_Delivery_Order::where('uuid',$request->sub_do_uuid)->first();
            if($sub_do == null) {
                $response['messages'] = "sub do is not found!";
                return json_encode($response);
            }

            $item_quantity = $request->item_quantity;
            if($item_quantity < 1) {
                $response['messages'] = "item quantity is not correct : ".$request->item_quantity." qty";
                return json_encode($response);
            }

            $item_name = $request->item_name;
            if($item_name == null) {
                $response['messages'] = "item name not found!";
                return json_encode($response);
            }

            $sub_do->quantity = $request->item_quantity;
            $sub_do->name = $request->item_name;
            $sub_do->save();

            $response['error'] = false;
            $response['data'] = $sub_do;

            return json_encode($response);

        } catch(Exception $e) {
            $response['messages'] = $e->getMessage();
            return json_encode($response);
        }

    }


    function restore_sub_do_by_uuid(Request $request) {
        $response = ["error"=>True,"messages"=>NULL,"data"=>NULL];

        try {
            $sub_po = Sub_Delivery_Order::withTrashed()->where('uuid',$request->sub_do_uuid)->first();
            if($sub_po == null) {
                $response['messages'] = "item is not found!";
                return json_encode($response);
            }

            $sub_po->restore();
            $response['error'] = false;
            return json_encode($response);
        } catch(Exception $e) {
            $response['messages'] = $e->getMessage();
            return json_encode($response);
        }
    }

    function added_sub_do_by_uuid(Request $request) {
        $response = ["error"=>True,"messages"=>NULL,"data"=>NULL];

        try {

            $do = Delivery_Order::where('uuid',$request->do_uuid)->first();
            if($do == null) {
                $response['messages'] = "delivery order data is not found!";
                return json_encode($response);
            }

            $item_quantity = $request->item_quantity;
            if($item_quantity < 1) {
                $response['messages'] = "item quantity is not correct : ".$request->item_quantity." qty";
                return json_encode($response);
            }

            $item_name = $request->item_name;
            if($item_name == null) {
                $response['messages'] = "item name not found!";
                return json_encode($response);
            }

            $sub_do = new Sub_Delivery_Order;
            $sub_do->quantity = $item_quantity;
            $sub_do->name = $item_name;
            
            $sub_do->delivery_order_id = $do->id;
            $sub_do->created_by = Auth::user()->id;
            $sub_do->updated_by = Auth::user()->id;
            $sub_do->uuid = $do->id."-".time()."-".$this->faker->uuid;
            $sub_do->save();

            $response['error'] = false;
            $response['data'] = $sub_do;

            return json_encode($response);
            
        } catch(Exception $e) {
            $response['messages'] = $e->getMessage();
            return json_encode($response);
        }
    }
}

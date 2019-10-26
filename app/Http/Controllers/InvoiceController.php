<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Models\Invoice;
use App\Http\Models\Sub_Invoice;
use App\Http\Models\Invoice_Status;

use App\User;
use App\Http\Models\Customer;
use App\Http\Models\PO;

class InvoiceController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {   


        $invoice = Invoice::leftjoin('invoice_status','invoice_status.id','=','invoice.status')
                    ->leftjoin('users','users.id','=','invoice.sales_id')
                    ->leftjoin('customer','customer.id','=','invoice.customer_id');
                    
        if($request->search == "on") { 

            if($request->search_nama != null) { 
                $invoice = $invoice->where('invoice.number','like',$request->search_nama."%");
            }

            if($request->search_sales != null) {
                $invoice = $invoice->where('invoice.sales_id','=', $request->search_sales);
                
            }

            if($request->search_customer != null) {
                $invoice = $invoice->where('invoice.customer_id','=', $request->search_customer);
                
            }

            if($request->search_po != null) {
                $invoice = $invoice->where('invoice.po_id','=', $request->search_po);
                
            }

            if($request->search_status != null) {
                $invoice = $invoice->where('invoice.status','=', $request->search_status);
            }



            if($request->uuid != null) {
                $invoice = $invoice->where('invoice.uuid','=',$request->uuid);
            }

        }

        $invoice = $invoice->select(
                        'invoice.*',
                        'users.name AS sales_name',
                        'customer.name AS customer_name',
                        'invoice_status.name AS status_name'
                    )
                    ->orderBy('number','desc')->paginate(2);


        foreach($invoice as $key=>$val) {
            $total = 0;
            
            $sub_inv_data = Sub_Invoice::where('invoice_id',$val->id)->get();
            if(count($sub_inv_data) > 0) {
                foreach($sub_inv_data as $sub_key=>$sub_val) {
                    $total += $sub_val["quantity"] * $sub_val["price"];
                }
            }

            $invoice[$key]["total"] = number_format($total);
        }

        $data['invoice'] = $invoice;
        $data['sales'] = User::all();
        $data['customer'] = Customer::all();
        $data['po'] = PO::all();
        $data['invoice_status'] = Invoice_Status::all();
        return view('invoice/index',compact('data'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
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


     public function get_invoice_by_uuid(Request $request) {
        $response = ["error"=>True,"messages"=>NULL,"data"=>NULL];
        try {
            $data["invoice"] = Invoice::leftjoin('po','po.id','=','invoice.po_id')
                    ->leftjoin('users','users.id','=','invoice.sales_id')
                    ->leftjoin('customer','customer.id','=','invoice.customer_id')
                    ->leftjoin('delivery_order','delivery_order.id','=','invoice.delivery_order_id')
                    ->leftjoin('invoice_status','invoice_status.id','=','invoice.status')
                    ->leftjoin('users as c_user','c_user.id','=','invoice.created_by')
                    ->leftjoin('users as u_user','u_user.id','=','invoice.updated_by')
                    ->where('invoice.uuid',$request->uuid)
                    ->select(
                        'invoice.*',
                        'po.number AS po_number',
                        'users.name AS sales_name',
                        'customer.name AS customer_name',
                        'delivery_order.number AS delivery_order_number',
                        'invoice_status.name AS status_name',
                        'c_user.name AS created_by_name',
                        'u_user.name AS updated_by_name'
                    )
                    ->first();


            if($data['invoice'] == null) {
                $response['messages'] = "no data delivery_order found!";
                return json_encode($response);
            }

            $data["sub_invoice"] = Sub_Invoice::where('invoice_id',$data['invoice']->id)->get();

            if(count($data['sub_invoice']) < 1) {
                $response['messages'] = "no detail invoice found!";
                return json_encode($response);
            }

            if(count($data) > 0) {
                $response['data'] = $data;
                $response['error'] = False;
                return json_encode($response);
            }

            $response['messages'] = "no data found!";
            return json_encode($response);

        } catch(Exception $e) {
            $response['messages'] = $e->getMessage();
            return json_encode($response);
        }


     }
}

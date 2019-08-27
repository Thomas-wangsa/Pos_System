<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Models\Invoice;
use App\Http\Models\Sub_Invoice;

class InvoiceController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {   


        $invoice = Invoice::leftjoin('po','po.id','=','invoice.po_id')
                    ->leftjoin('users','users.id','=','invoice.sales_id')
                    ->leftjoin('invoice_status','invoice_status.id','=','invoice.status')
                    ->select('invoice.*','po.number AS po_number','users.name AS sales_name','invoice_status.name AS status_name')
                    ->get();

        foreach($invoice as $key=>$val) {
            $invoice[$key]["total"] = Sub_Invoice::where('invoice_id',$val->id)->sum('total');
        }

        $data['invoice'] = $invoice;
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
                    ->leftjoin('invoice_status','invoice_status.id','=','invoice.status')
                    ->leftjoin('users as c_user','c_user.id','=','invoice.created_by')
                    ->leftjoin('users as u_user','u_user.id','=','invoice.updated_by')
                    ->where('invoice.uuid',$request->uuid)
                    ->select(
                        'invoice.*',
                        'po.number AS po_number',
                        'users.name AS sales_name',
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

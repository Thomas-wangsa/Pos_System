<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use App\Http\Models\Customer;
use App\Http\Models\Payment_Method;
use App\Http\Models\Invoice;

class ReportController extends Controller
{   
    protected $redirectTo      = 'report.index';
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {   
        $data['from_date'] =  date('Y-m-d', strtotime("-7 day"));
        $data['to_date'] = date('Y-m-d');
        $data['sales'] = User::all();
        $data['customer'] = Customer::all();
        $data['payment_method'] = Payment_Method::all();
        return view('report/index',compact('data'));
    }


    public function get_report(Request $request) {

        $from_date = $request->from_date;
        $to_date = $request->to_date;

        $invoice = Invoice::all();

        if(count($invoice) < 1) {
            $request->session()->flash('alert-danger', "invoice data is not found!");
            return redirect()->route($this->redirectTo);
        }

        dd($request);
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
}

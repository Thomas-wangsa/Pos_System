<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use App\Http\Models\Customer;
use App\Http\Models\Payment_Method;
use App\Http\Models\Invoice;
use Illuminate\Support\Facades\DB;


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
        return view('report/index',compact('data'));
    }


    public function get_report(Request $request) {
        $from_date = $request->from_date;
        if($from_date == null) {
            $from_date = date('Y-m-d', strtotime("-7 day"));
        }

        $to_date = $request->to_date;
        if($to_date == null) {
            $to_date = date('Y-m-d');
        }



        $report = Invoice::select('invoice_status.name as status',DB::raw('SUM(sub_data.total) AS total'))
                ->leftjoin(
                    DB::raw('(SELECT invoice_id, SUM(quantity * price) as total FROM `sub_invoice` GROUP BY invoice_id) sub_data'),
                    'invoice.id','=','sub_data.invoice_id')
                ->join('invoice_status','invoice.status','=','invoice_status.id')
                ->whereDate('invoice.created_at','>=',$request->from_date)
                ->whereDate('invoice.created_at','<=',$request->to_date);

        $title = "Report from $from_date - $to_date";

        if($request->search_sales != null) {
            $report = $report->where('invoice.sales_id','=',$request->search_sales);
        }

        if($request->search_customer != null) {
            $report = $report->where('invoice.customer_id','=',$request->search_customer);
        }

        $report = $report->groupBy('status')->get();


        if(count($report) < 1) {
            $request->session()->flash('alert-danger', "no report found");
            return redirect()->route($this->redirectTo);
        }

        // $query_raw = "SELECT inv.status, SUM(sub_data.total) as total ";
        // $query_raw .= "FROM invoice inv ";
        // $query_raw .= "LEFT JOIN ( ";
        //     $query_raw .= "SELECT invoice_id, SUM(quantity * price) as total ";
        //     $query_raw .= "FROM `sub_invoice` ";
        //     $query_raw .= "GROUP BY invoice_id ";
        // $query_raw .= ") sub_data ";
        // $query_raw .= "ON sub_data.invoice_id = inv.id ";
        // $query_raw .= "GROUP BY inv.status";

        // $data = DB::select($query_raw);

        
        $data["report"] = $report;
        $data["title"] = $title;

        // dd($data);
        return view('report/report',compact('data'));
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

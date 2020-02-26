<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use App\Http\Models\Customer;
use App\Http\Models\PO;

use App\Http\Models\Payment_Method;
use App\Http\Models\Invoice;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
class ReportPOController extends Controller
{   
    protected $redirectTo      = 'report_po.index';
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
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

        $sales = User::all();

        if(!$allowed) {
            $sales = User::where('id',Auth::user()->id)->get();
        }

        $data['from_date'] =  date('Y-m-d', strtotime("-7 day"));
        $data['to_date'] = date('Y-m-d');
        $data['sales'] = $sales;
        return view('report_po/index',compact('data'));
    }


    public function get_po_report(Request $request) {
        $from_date = $request->from_date;
        if($from_date == null) {
            $from_date = date('Y-m-d', strtotime("-7 day"));
        }

        $to_date = $request->to_date;
        if($to_date == null) {
            $to_date = date('Y-m-d');
        }



        $report = PO::select('po_status.name as status',DB::raw('SUM(sub_data.total) AS total'))
                ->leftjoin(
                    DB::raw('(SELECT po_id, SUM(quantity * price) as total FROM `sub_po` GROUP BY po_id) sub_data'),
                    'po.id','=','sub_data.po_id')
                ->join('po_status','po.status','=','po_status.id')
                ->whereDate('po.created_at','>=',$request->from_date)
                ->whereDate('po.created_at','<=',$request->to_date);

        $title = "Report PO from $from_date - $to_date";

        if($request->search_sales != null) {
            $report = $report->where('po.sales_id','=',$request->search_sales);
        }

        if($request->search_customer != null) {
            $report = $report->where('po.customer_id','=',$request->search_customer);
        }

        $report = $report->groupBy('status')->get();


        if(count($report) < 1) {
            $request->session()->flash('alert-danger', "no report found");
            return redirect()->route($this->redirectTo);
        }

        
        $data["report"] = $report;
        $data["title"] = $title;

        // dd($data);
        return view('report_po/report',compact('data'));
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

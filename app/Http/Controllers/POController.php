<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Models\Category;
use App\Http\Models\Customer;
use App\Http\Models\PO;
use App\Http\Models\SubPO;

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
        $category = Category::all();
        $po = PO::all();
        $data['category'] = $category;
        //$data['customer'] = $customer;
        $data['po'] = $po;
        //dd($data);
        return view('po/index',compact('data'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        $customer = Customer::where('uuid',$request->customer_uuid)->first();


        $data['customer'] = $customer;

        // dd($customer);
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
        $po->name = $request->po['po_name'];
        $po->date = $request->po['po_date'];
        $po->note = $request->po['po_note'];
        $po->uuid = $this->faker->uuid;
        $po->created_by = Auth::user()->id;
        $po->updated_by = Auth::user()->id;
        $po->save();
        // return view('po/create',compact('data')); 
        // dd($request->subData);

        $full_data = array();
        for($i=0;$i<count($request->subData);$i++) { 
            $customer_array = array(
                "po_id"=>$po->id,
                "quantity"=>$request->subData[$i]['quantity'],
                "name"=>$request->subData[$i]['name'],
                "price"=>$request->subData[$i]['price'],
                "status"=>$request->subData[$i]['status'],
                "note"=>$request->subData[$i]['note'],
                "uuid"=>$this->faker->uuid,
                "created_by"=>Auth::user()->id,
                "updated_by"=>Auth::user()->id,
                "created_at"=>date("Y-m-d H:i:s"),
                "updated_at"=>date("Y-m-d H:i:s"), 
            );

            array_push($full_data,$customer_array);

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
}

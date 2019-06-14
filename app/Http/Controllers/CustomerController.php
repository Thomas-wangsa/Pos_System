<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;

use Illuminate\Http\Request;
use App\Http\Models\Category;
use App\Http\Models\Customer;

class CustomerController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {   
        $customers = Customer::leftjoin('category','category.id','=','customers.category_id')
                    ->select('customers.*','category.name AS category_name')
                    ->get();
        // dd($customer);
        $category = Category::all();
        $data['category'] = $category;
        $data['customers'] = $customers;
        return view('customer/index',compact('data'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        

        $customer = Customer::all();

        $category = Category::all();
        $data['category'] = $category;
        $data['customer'] = $customer;
        return view('customer/create',compact('data'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $new_customer = new Customer;

        $new_customer->category_id = $request->category;
        $new_customer->name = $request->name;
        $new_customer->uuid = "123456";
        $new_customer->mobile = $request->mobile;
        $new_customer->created_by = Auth::user()->id;
        $new_customer->updated_by = Auth::user()->id;
        $new_customer->save();
        return redirect()->route('customer.index');
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

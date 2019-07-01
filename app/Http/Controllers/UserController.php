<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use Faker\Factory as Faker;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{   
    protected $faker;
    protected $redirectTo      = 'user.index';
    
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
        $users = User::all();
        $data['users'] = $users;
        return view('user/index',compact('data'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('user/create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {   
        $new_user = new User;

        $new_user->name = $request->name;
        $new_user->email = $request->email;
        $new_user->phone = $request->phone;
        $new_user->role = $request->role;
        $new_user->password = bcrypt($request->password);
        $new_user->uuid  = $this->faker->uuid;
        $new_user->created_by = Auth::user()->id;
        $new_user->updated_by = Auth::user()->id;

        $new_user->save();
        return redirect()->route($this->redirectTo);

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

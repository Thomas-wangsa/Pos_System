<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use App\Http\Models\UserRole;
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
        $users = User::leftjoin('user_role','user_role.id','=','users.role')
                ->select('users.*','user_role.name AS role_name')
                ->orderBy('users.id','ASC')
                ->get();
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
        $data['user_role'] = UserRole::whereIn('id',array(2,3))->get();
        $data['faker'] = $this->faker;
        return view('user/create',compact('data'));
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
        $new_user->uuid  = time()."-".$this->faker->uuid;
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
        
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $data['user']       = User::where('uuid',$id)->first();
        $data['user_role'] = UserRole::all();
        // $data['faker'] = $this->faker;
        return view('user/edit',compact('data'));
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
        $user = User::where('uuid',$id)->first();


        if($request->role) {
            $user->role = $request->role;
        }

        $user->name = $request->name;
        $user->email = $request->email;
        $user->phone = $request->phone;
        $user->updated_by = Auth::user()->id;
        $user->save();
        return redirect()->route($this->redirectTo);
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

            $user = User::where('uuid',$id)->first()->delete();
  
            $response['error'] = false;
            return json_encode($response);
        } catch(Exception $e) {
            $response['messages'] = $e->getMessage();
            return json_encode($response);
        }
        
    }


    public function get_user_by_uuid(Request $request) {
        $response = ["error"=>True,"messages"=>NULL,"data"=>NULL];

        try{
            $data = User::leftjoin('user_role','user_role.id','=','users.role')
                ->leftjoin('users as ca','ca.id','=','users.created_by')
                ->leftjoin('users as cu','cu.id','=','users.updated_by')
                ->where('users.uuid',$request->uuid)
                ->select('users.*','user_role.name AS role_name','ca.name AS created_by_name','cu.name AS updated_by_name')
                ->first();

            if($data == null) {
                $response['messages'] = "no data user found!";
                return json_encode($response);
            }

            if(count($data) > 0) {
                $response['data'] = $data;
                $response['error'] = False;
                return json_encode($response);
            }

        }
        //catch exception
        catch(Exception $e) {
            $response['messages'] = $e->getMessage();
            return json_encode($response);
        }
    }
}

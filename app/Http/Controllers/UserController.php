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
    public function index(Request $request)
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

        if(!$allowed) {
            $request->session()->flash('alert-danger', "only admin and owner is allowed!");
            return redirect()->route("home");
        }


        $users = User::leftjoin('user_role','user_role.id','=','users.role');

        if($request->search == "on") { 


            if($request->search_nama != null) { 
                $users = $users->where('users.name','like',$request->search_nama."%");
            }

            if($request->search_filter != null) {
                if($request->search_filter == "is_deleted") {
                    $users =  User::onlyTrashed();
                    $users = $users->leftjoin('user_role','user_role.id','=','users.role');
                } else {
                    $users = $users->where('user_role.id','=', $request->search_filter);
                }
            }


            if($request->uuid != null) {
                $users = $users->where('users.uuid','=',$request->uuid);
            }

        }

        $users = $users->select('users.*','user_role.name AS role_name');

        if($request->search_order != null) {
                $users = $users->orderBy($request->search_order, 'asc');
        }

        $users = $users->paginate(10);
        $data['users'] = $users;
        $data['user_role'] = UserRole::all();
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
        try {

            if($request->password != $request->re_password) {
                $request->session()->flash('alert-danger', "password is not match!");
                return redirect()->route("user.create");
            }

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
            $request->session()->flash('alert-success', $new_user->name.' has been created');
            return redirect()->route($this->redirectTo,"search=on&uuid=".$new_user->uuid);
        } //catch exception
        catch(Exception $e) {
            $request->session()->flash('alert-danger', $e->getMessage());
            return redirect()->route($this->redirectTo);
        }
         
        

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
        if($user==null) {
            $request->session()->flash('alert-danger', 'user is not found!');
            return redirect()->route($this->redirectTo);
        }

        if($request->role) {
            $user->role = $request->role;
        }

        if($request->password) {
            if($request->password != null) {
                $user->password = bcrypt($request->password);
            }
        }

        $user->name = $request->name;
        $user->email = $request->email;
        $user->phone = $request->phone;
        $user->updated_by = Auth::user()->id;
        $user->save();
        $request->session()->flash('alert-success', $user->name.' has been updated');
        return redirect()->route($this->redirectTo,"search=on&uuid=".$user->uuid);
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


    public function restore_user_by_uuid(Request $request) {
        $response = ["error"=>True,"messages"=>NULL,"data"=>NULL];

        try{
            $data = User::withTrashed()->where('uuid',$request->uuid)->restore();

            if($data) {
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

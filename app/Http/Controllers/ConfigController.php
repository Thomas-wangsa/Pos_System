<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Http\Models\Category;
use App\Http\Models\Driver;
use Faker\Factory as Faker;
use App\User;

class ConfigController extends Controller
{   
    protected $redirectTo = 'config';
    protected $faker;

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
        if($role == 1) {
            $allowed = true;
        }

        if(!$allowed) {
            $request->session()->flash('alert-danger', "only owner is allowed!");
            return redirect()->route("home");
        }

        $config = array(
            "Category"    => 1,
            "Driver"    => 2,

        );

        $data = array(
            'config'    => $config,
            'rows'      => null
        );
    
        if($request->search == "on") { 
            $rows = null;
            if($request->search_filter != null) {
                switch ($request->search_filter) {
                    case '1':
                        if($request->search_nama != null) {$rows = Category::GetConfig($request->search_nama)->get();}
                        else {$rows = Category::GetConfig()->withTrashed()->get();}
                        break;
                    case '2':
                        if($request->search_nama != null) {$rows = Driver::GetConfig($request->search_nama)->get();}
                        else {$rows = Driver::GetConfig()->withTrashed()->get();}
                        break;
                    default:
                        $request->session()->flash('alert-danger', "Out Of Scope Category value : $request->config_category");
                        return redirect($this->redirectTo);
                        break;
                }
            }
            $data['rows'] = $rows;

        }
        $data['faker'] = $this->faker;
        return view('config/index',compact('data'));
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
        $request->validate([
            'config_main'  => 'required|max:30',
            'config_additional'  => 'required|max:300',
            'config_category'  => 'required|max:30',
        ]);


        switch ($request->config_category) {
            case '1':
                $data_exists = Category::where('name', $request->config_main)->first();

                if($data_exists) {
                    $request->session()->flash('alert-danger', "Data already exists in Category : $request->config_main");
                    return redirect($this->redirectTo);
                }


                $data  = new Category;
                $data->name      = $request->config_main;
                $data->detail    = $request->config_additional;
                $data->uuid      = time()."-".$this->faker->uuid;

                break;
            case '2':
                $data_exists = Driver::where('name', $request->config_main)->first();

                if($data_exists) {
                    $request->session()->flash('alert-danger', "Data already exists in Driver : $request->config_main");
                    return redirect($this->redirectTo);
                }


                $data  = new Driver;
                $data->name      = $request->config_main;
                $data->detail    = $request->config_additional;
                $data->uuid      = time()."-".$this->faker->uuid;


                break;
            default:
                $request->session()->flash('alert-danger', "Out Of Scope Category value : $request->config_category");
                return redirect($this->redirectTo);
                break;
        }

        $data->created_by = Auth::user()->id;
        $data->updated_by = Auth::user()->id;
        $data->created_at = date('Y-m-d H:i:s');
        $data->updated_at = date('Y-m-d H:i:s');

        if($data->save()) {
            $request->session()->flash('alert-success', "the $request->config_main have been added to category");
        } else {
            $request->session()->flash('alert-danger', "Data is not save, Please contact your administator");
        }
        
        return redirect($this->redirectTo."?search=on&search_nama=&search_filter=".$request->config_category);
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


    public function edit_config(Request $request) {
        $data_exists = Category::where('uuid', $request->uuid)->first();

        if($data_exists == null) {
            $request->session()->flash('alert-danger', "Data not found!");
            return redirect($this->redirectTo);
        }


        $data['category'] = $data_exists;
        return view('config/edit_config',compact('data'));
    }

    public function update_config(Request $request) {
        $category = Category::where('uuid', $request->uuid)->first();

        if($category == null) {
            $request->session()->flash('alert-danger', "Update Failed : Data not found!");
            return redirect($this->redirectTo);
        }

        $category->name     = $request->name;
        $category->detail   = $request->detail;
        $category->save(); 
        $request->session()->flash('alert-success', 'Config : '. $category->name.' already updated');
        return redirect($this->redirectTo."?search=on&search_nama=&search_filter=1");
    }


    public function edit_driver(Request $request) {
        $data_exists = Driver::where('uuid', $request->uuid)->first();

        if($data_exists == null) {
            $request->session()->flash('alert-danger', "Data not found!");
            return redirect($this->redirectTo);
        }


        $data['driver'] = $data_exists;
        return view('config/edit_driver',compact('data'));
    }

     public function update_driver(Request $request) {
        $driver = Driver::where('uuid', $request->uuid)->first();

        if($driver == null) {
            $request->session()->flash('alert-danger', "Update Failed : Data not found!");
            return redirect($this->redirectTo);
        }

        $driver->name     = $request->name;
        $driver->detail   = $request->detail;
        $driver->save(); 
        $request->session()->flash('alert-success', 'Driver : '. $driver->name.' already updated');
        return redirect($this->redirectTo."?search=on&search_nama=&search_filter=2");
    }


    public function delete_config(Request $request) {
        $type = $request->type;

        if($type != 1 && $type != 2) {
            $request->session()->flash('alert-danger', "Delete Failed : Type is undefined!");
            return redirect($this->redirectTo);
        }


        if($type == 1) {
            $category = Category::where('uuid',$request->uuid)->first();
            
            if($category == null) {
                $request->session()->flash('alert-danger', "Data not found!");
                return redirect($this->redirectTo);
            }
            $category->delete();
            $request->session()->flash('alert-success', 'Category : '. $category->name.' already deleted');
            return redirect($this->redirectTo."?search=on&search_nama=&search_filter=1");
        } else if ($type == 2) {
            $driver = Driver::where('uuid',$request->uuid)->first();

             if($driver == null) {
                $request->session()->flash('alert-danger', "Data not found!");
                return redirect($this->redirectTo);
            }
            $driver->delete();

            $request->session()->flash('alert-success', 'Driver : '. $driver->name.' already deleted');
            return redirect($this->redirectTo."?search=on&search_nama=&search_filter=2");
        } else {
            $request->session()->flash('alert-danger', "Delete Failed : Out of scope");
            return redirect($this->redirectTo);
        }
    }

    public function restore_config(Request $request) {
        $type = $request->type;

        if($type != 1 && $type != 2) {
            $request->session()->flash('alert-danger', "Restore Failed : Type is undefined!");
            return redirect($this->redirectTo);
        }


        if($type == 1) {
            $category = Category::withTrashed()->where('uuid',$request->uuid)->first();
            
            if($category == null) {
                $request->session()->flash('alert-danger', "Data not found!");
                return redirect($this->redirectTo);
            }
            $category->restore();
            $request->session()->flash('alert-success', 'Category : '. $category->name.' already restore');
            return redirect($this->redirectTo."?search=on&search_nama=&search_filter=1");
        } else if ($type == 2) {
            $driver = Driver::withTrashed()->where('uuid',$request->uuid)->first();

             if($driver == null) {
                $request->session()->flash('alert-danger', "Data not found!");
                return redirect($this->redirectTo);
            }
            $driver->restore();

            $request->session()->flash('alert-success', 'Driver : '. $driver->name.' already restore');
            return redirect($this->redirectTo."?search=on&search_nama=&search_filter=2");
        } else {
            $request->session()->flash('alert-danger', "Restore Failed : Out of scope");
            return redirect($this->redirectTo);
        }
    }
}

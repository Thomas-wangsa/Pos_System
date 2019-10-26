@extends('layouts.main')

@section('content')

  @foreach (['danger', 'warning', 'success', 'info'] as $msg)
      @if(Session::has('alert-' . $msg))

      <p class="alert alert-{{ $msg }}">{{ Session::get('alert-' . $msg) }} 
        <a href="#" class="close" data-dismiss="alert" aria-label="close">
          &times;
        </a>
     </p>
      @endif
  @endforeach
  <div style="margin-top: 15px">
    <div class="pull-left">
      <a href="{{route('user.create')}}">
        <button type="button" class="btn btn-md btn-primary">
          <span class="glyphicon glyphicon-plus"></span>
          New Users
        </button>
      </a>
    </div>
    <div class="clearfix"> </div>
  </div>

  <div class="pull-left" style="margin: 10px auto">
    <form class="form-inline" action="">
      <input type="hidden" name="search" value="on"> </input>
      <div class="form-group">
        <div class="input-group">
          <span class="input-group-addon">
            <i class="glyphicon glyphicon-search">
            </i>
          </span>
          <input type="text" class="form-control" 
          name="search_nama" placeholder="Find Name..."
          value="{{Request::get('search_nama')}}">
        </div>
      </div>
      
      <div class="form-group">
        <select class="form-control" name="search_filter">
          <option value=""> Filter By </option>
          @foreach($data['user_role'] as $key=>$val)
          <option value="{{$val->id}}"
          @if($val->id == Request::get('search_filter')) 
            selected
          @endif  
          > {{$val->name}} </option>
          @endforeach
          <option value="is_deleted"
          @if('is_deleted' == Request::get('search_filter')) 
            selected
          @endif
          > 
          Deleted Users 
          </option> 
        </select>
      </div>

      <div class="form-group">
          <select class="form-control" name="search_order">
            <option value=""> Sort By </option>
            <option value="name"
              @if('name' == Request::get('search_order')) 
              selected
            @endif
            > 
              Name 
            </option>
            <option value="email"
              @if('email' == Request::get('search_order')) 
              selected
            @endif
              > 
              Email 
            </option>
          </select>
      </div>
    
      <button type="submit" class="btn btn-info"> 
        Filter
      </button> 

      @if(Request::get('search') == "on")
      <button type="reset" 
      class="btn"
      onclick="reset_filter()"> 
        Clear Filter 
      </button>
      @endif
    </form>
  </div>
  <div class="clearfix"> </div>


  <table class="table table-striped table-bordered table-responsive">
    <thead>
      <tr>
        <th> No </th>
        <th> User Name </th>
        <th> Email </th>
        <th> Phone </th>
        <th> Role </th>
        <th> Action </th>
      </tr>
    </thead>
    <tbody>
      @if (count($data['users']) == 0 ) 
      <td colspan="10" class="text-center"> 
        No User Found! 
      </td>
      @else 
        @foreach($data['users'] as $key=>$val)
        <tr>
          <td> 
            {{ ($data['users']->currentpage()-1) 
            * $data['users']->perpage() + $key + 1 }}
          </td>
          <td>
            {{$val['name']}}
          </td>
          <td>
            {{$val['email']}}
          </td>
          <td>
            {{$val['phone']}}
          </td>
          <td>
            {{$val['role_name']}}
          </td>
          <td>
            <?php $uuid = $val['uuid']; $name = $val['name'];?>

            @if(Request::get('search_filter') == 'is_deleted')
              <button class="btn btn-primary"
              onclick="restore_user('{{$uuid}}')">
                restore user
              </button>
            @else 
              <span class="glyphicon glyphicon-file"
              style="cursor:pointer;color:#337ab7" 
              title="detail {{$val['name']}}" 
              onclick='info("{{$uuid}}")' 
              >
              </span>
              &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;

              <a href="{{route('user.edit',$uuid)}}">
                <span class="glyphicon glyphicon-edit"
                style="color:green;cursor:pointer" 
                title="edit {{$val['name']}}"
                >
                </span>
              </a> 
              &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
              
              @if(Auth::user()->role == 1)
              <span class="glyphicon glyphicon-trash"
              style="color:red;cursor:pointer" 
              title="remove {{$val['name']}}"
              onclick='destroy("{{$uuid}}","{{$name}}")'   
              >
              </span>
              &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
              @endif
            @endif

          </td>
        </tr>
        @endforeach
      @endif
    </tbody>
  </table>

  <div class="pull-right" style="margin-top: -15px!important"> 
    {{ $data['users']->appends(
      [
      'search' => Request::get('search'),
      'search_nama' => Request::get('search_nama'),
      'search_filter' => Request::get('search_filter'),
      'search_order' => Request::get('search_order')
      ])

    ->links() }}
  </div>
  <div class="clearfix"> </div>

  @include('user.modal_info')


  <script type="text/javascript">
    function destroy(uuid,name) {
      if (confirm('Apakah anda yakin ingin menghapus Akun '+name+' ?')) {
        var payload = {"uuid":uuid,"_method": 'DELETE'};


        $.ajax({
          type : "POST",
          url: " {!! url('user' ) !!}" + "/" + uuid,
          contentType: "application/json",
          data : JSON.stringify(payload),
          success: function(result) {
            response = JSON.parse(result);
            if(response.error != true) {
              alert("Deleted user " +name+" success");
              window.location = "{{route('user.index')}}";
            } else {
              alert(response.messages);
            }

          }

        });

      }
    }

    function reset_filter() {
      window.location = "{{route('user.index')}}";
    }


    function restore_user(uuid) {
      $(document).ready(function(){
        if (confirm('Apakah anda yakin ingin restore Akun ini ?')) {

          var data = {
            "uuid":uuid
          };

          $.ajax({
            type : "POST",
            url: " {{ route('user.restore_user_by_uuid') }}",
            contentType: "application/json",
            data : JSON.stringify(data),
            success: function(result) {
              response = JSON.parse(result);
              if(response.error != true) {
                alert("restore user success");
                window.location = "{{route('user.index')}}";
              } else {
                alert(response.messages);
              }
            },
            error: function( jqXhr, textStatus, errorThrown ){
                console.log( errorThrown );
            }
          });
        } 
      });
    };
  </script>
@endsection


@extends('layouts.main')

@section('content')
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
        </select>
      </div>

      <div class="form-group">
          <select class="form-control" name="search_order">
            <option value=""> Sort By </option>
          </select>
      </div>
    
      <button type="submit" class="btn btn-info"> 
        Filter
      </button> 
    </form>
  </div>
  <div class="clearfix"> </div>


  <table class="table table-striped table-bordered table-responsive">
    <thead>
      <tr>
        <th> No </th>
        <th> Name </th>
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
            {{$key+1}}
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
            
            <span class="glyphicon glyphicon-trash"
            style="color:red;cursor:pointer" 
            title="remove {{$val['name']}}"
            onclick='destroy("{{$uuid}}","{{$name}}")'   
            >
            </span>
            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;

            <a href="#">
              <span class="glyphicon glyphicon-cog"
              style="color:black;cursor:pointer" 
              title="setting {{$val['name']}}"  
              >
              </span>
            </a> 
            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
          </td>
        </tr>
        @endforeach
      @endif
    </tbody>
  </table>

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
              window.location = "{{route('user.index')}}";
            } else {
              alert(response.messages);
            }

          }

        });

      }
    }
  </script>
@endsection


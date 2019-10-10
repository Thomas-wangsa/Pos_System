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
      <a href="{{route('customer.create')}}">
        <button type="button" class="btn btn-md btn-warning">
          <span class="glyphicon glyphicon-plus"></span>
          New Customer
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
        <select class="form-control" name="search_sales">
          <option value=""> Filter By Sales </option>
          @foreach($data['sales'] as $key=>$val)
          <option value="{{$val->id}}"
          @if($val->id == Request::get('search_sales')) 
            selected
          @endif  
          > {{$val->name}} </option>
          @endforeach
        </select>
      </div>

      <div class="form-group">
        <select class="form-control" name="search_status">
          <option value=""> Filter By Status </option>
          @foreach($data['customer_status'] as $key=>$val)
          <option value="{{$val->id}}"
          @if($val->id == Request::get('search_status')) 
            selected
          @endif  
          > {{$val->name}} </option>
          @endforeach
          <option value="is_deleted"
          @if('is_deleted' == Request::get('search_status')) 
            selected
          @endif
          > 
          Deleted Customer 
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
            <option value="owner"
              @if('owner' == Request::get('search_order')) 
              selected
            @endif
              > 
              Owner 
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
        <th> Customer Name </th>
        <th> Owner </th>
        <th> Phone </th>
        <th> Sales </th>
        <th> Action </th>
      </tr>
    </thead>
    <tbody>
      @if (count($data['customer']) == 0 ) 
      <td colspan="10" class="text-center"> 
        No Customer Found! 
      </td>
      @else 
        @foreach($data['customer'] as $key=>$val)
        <tr>
          <td> 
            {{ ($data['customer']->currentpage()-1) 
            * $data['customer']->perpage() + $key + 1 }}
          </td>
          <td>
            {{$val['name']}}
          </td>
          <td>
            {{$val['owner']}}
          </td>
          
          <td>
            {{$val['phone']}}
          </td>
          <td>
            {{$val['sales_name']}}
          </td>
          
          <td>
            <?php $uuid = $val['uuid']; $name = $val['name'];?>
            @if(Request::get('search_status') == 'is_deleted')
              <button class="btn btn-primary"
              onclick="restore('{{$uuid}}')">
                restore customer
              </button>
            @else

              <a href="#">  
                <span class="glyphicon glyphicon-file"
                style="cursor:pointer" 
                title="detail {{$val['name']}}" 
                onclick='info("{{$uuid}}")' 
                >
                </span>
              </a>
              &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;

              <a href="{{route('customer.edit',$uuid)}}">
                <span class="glyphicon glyphicon-edit"
                style="color:green;cursor:pointer" 
                title="edit {{$val['name']}}"
                >
                </span>
              </a> 
              &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
              

              <a href="#">
                <span class="glyphicon glyphicon-trash"
                style="color:red;cursor:pointer" 
                title="remove {{$val['name']}}"
                onclick='destroy("{{$uuid}}","{{$name}}")'  
                >
                </span>
              </a> 
              &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
              
              <a href="{{route('po.create')}}?customer_uuid={{$val['uuid']}}">  
                <span class="glyphicon glyphicon-play-circle"
                style="cursor:pointer;color:black" 
                title="create new PO" 
                >
                </span>
              </a>
              &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
            @endif
                
          </td>
        </tr>
        @endforeach
      @endif
    </tbody>
  </table>

  <div class="pull-right" style="margin-top: -15px!important"> 
    {{ $data['customer']->appends(
      [
      'search' => Request::get('search'),
      'search_nama' => Request::get('search_nama'),
      'search_sales' => Request::get('search_sales'),
      'search_status' => Request::get('search_status'),
      'search_order' => Request::get('search_order')
      ])

    ->links() }}
  </div>
  <div class="clearfix"> </div>

  @include('customer.modal_info')

  <script type="text/javascript">
    function destroy(uuid,name) {
      if (confirm('Apakah anda yakin ingin menghapus Customer '+name+' ?')) {
        var payload = {"uuid":uuid,"_method": 'DELETE'};


        $.ajax({
          type : "POST",
          url: " {!! url('customer' ) !!}" + "/" + uuid,
          contentType: "application/json",
          data : JSON.stringify(payload),
          success: function(result) {
            response = JSON.parse(result);
            if(response.error != true) {
              alert("Deleted customer " +name+" success");
              window.location = "{{route('customer.index')}}";
            } else {
              alert(response.messages);
            }

          }

        });

      }
    }

    function reset_filter() {
      window.location = "{{route('customer.index')}}";
    }


    function restore(uuid) {
      $(document).ready(function(){
        if (confirm('Apakah anda yakin ingin restore Akun ini ?')) {

          var data = {
            "uuid":uuid
          };

          $.ajax({
            type : "POST",
            url: " {{ route('customer.restore_customer_by_uuid') }}",
            contentType: "application/json",
            data : JSON.stringify(data),
            success: function(result) {
              response = JSON.parse(result);
              if(response.error != true) {
                alert("restore customer success");
                window.location = "{{route('customer.index')}}";
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

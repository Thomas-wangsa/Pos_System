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

  @if(Auth::user()->role == 1 OR Auth::user()->role == 2)
  <div style="margin-top: 15px">
    <div class="pull-left">
      <button type="button" class="btn btn-md btn-primary" data-toggle="modal" data-target="#modal_select_customer">
        <span class="glyphicon glyphicon-plus"></span>
        New PO
      </button>
    </div>
    <div class="clearfix"> </div>
  </div>
  @endif

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
        <select class="form-control" name="search_customer">
          <option value=""> Filter By Customer </option>
          @foreach($data['all_customer'] as $key=>$val)
          <option value="{{$val->id}}"
          @if($val->id == Request::get('search_customer')) 
            selected
          @endif  
          > {{$val->name}} </option>
          @endforeach
        </select>
      </div>

      

      
      <div class="form-group">
        <select class="form-control" name="search_status">
          <option value=""> Filter By Status </option>
          @foreach($data['po_status'] as $key=>$val)
          <option value="{{$val->id}}"
          @if($val->id == Request::get('search_status')) 
            selected
          @endif  
          > {{$val->name}} </option>
          @endforeach
        </select>
      </div>

      <div class="form-group">
          <select class="form-control" name="search_order">
            <option value=""> Sort By </option>
            <option value="oldest_po"
              @if('oldest_po' == Request::get('search_order')) 
              selected
            @endif
            > 
              Oldest PO 
            </option>
            <option value="status"
              @if('status' == Request::get('search_order')) 
              selected
            @endif
              > 
              Status 
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
        <th> Number </th>
        <th> Total </th>
        <th> Status </th>
        <th> Action </th>
      </tr>
    </thead>
    <tbody>
       @if (count($data['po']) == 0 ) 
      <td colspan="10" class="text-center"> 
        No PO Found! 
      </td>
      @else 
        @foreach($data['po'] as $key=>$val)
        <?php $uuid = $val["uuid"];?>
        <tr>
          <td>
            {{ ($data['po']->currentpage()-1) 
            * $data['po']->perpage() + $key + 1 }}
          </td>
          <td>
            {{$val['number']}}
          </td>
          
          <td>
            Rp. {{ number_format($val['total']) }} 
          </td>

          <td>
            {{$val['status_name']}}
          </td>
          <td>
        
            <a href="#" onclick="info('{{$uuid}}')">  
              <span class="glyphicon glyphicon-file"
              style="cursor:pointer" 
              title="detail PO {{$val['number']}}" 
              >
              </span>
            </a>
            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;

            @if(Auth::user()->role == 1 OR Auth::user()->role == 2)
            <a href="{{route('po.edit',$uuid)}}">
              <span class="glyphicon glyphicon-edit"
              style="color:green;cursor:pointer" 
              title="edit PO {{$val['number']}}"
              >
              </span>
            </a> 
            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
            

            <a href="#" onclick="select_sub_po_status('{{$uuid}}')">
              <span class="glyphicon glyphicon-check"
              style="cursor:pointer;color:red" 
              title="set flag PO {{$val['number']}}"  
              >
              </span>
            </a> 
            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;

            <a href="{{route('do.create')}}?po_uuid={{$val['uuid']}}">  
              <span class="glyphicon glyphicon-play-circle"
              style="cursor:pointer;color:black" 
              title="create new DO & Invoice for PO {{$val['number']}}" 
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
    {{ $data['po']->appends(
      [
      'search' => Request::get('search'),
      'search_nama' => Request::get('search_nama'),
      'search_customer' => Request::get('search_customer'),
      'search_sales' => Request::get('search_sales'),
      'search_status' => Request::get('search_status'),
      'search_order' => Request::get('search_order')
      ])

    ->links() }}
  </div>
  <div class="clearfix"> </div>


<script type="text/javascript">
  $.ajaxSetup({
    headers: {
      'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    }
  });
  function reset_filter() {
      window.location = "{{route('po.index')}}";
    }
</script>

  @include('po.modal_select_customer')
  @include('po.modal_select_po_status')
  @include('po.modal_info_po')
@endsection

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
        <select class="form-control" name="search_customer">
          <option value=""> Filter By Sales </option>
          
        </select>
      </div>

      <div class="form-group">
        <select class="form-control" name="search_customer">
          <option value=""> Filter By Customer </option>
          
        </select>
      </div>


      <div class="form-group">
        <select class="form-control" name="search_po">
          <option value=""> Filter By PO </option>
        </select>
      </div>

      
     
      <div class="form-group">
        <select class="form-control" name="search_status">
          <option value=""> Filter By Status </option>
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
        <th> Sales </th>
        <th> Customer </th>
        <th> Total </th>
        <th> Status </th>
        <th> Action </th>
      </tr>
    </thead>
    <tbody>
        @if (count($data['invoice']) == 0 ) 
          <tr> 
            <td colspan="10" class="text-center"> 
            No Invoice Data Found! 
            </td>
          </tr>
        @else
          @foreach($data['invoice'] as $key=>$val)
          <?php $uuid = $val["uuid"];?>
          <tr>
            <td> {{$key+1}} </td>
            <td> {{$val->number}}</td>
            <td> {{$val->sales_name}}} </td>
            <td> {{$val->customer_name}}} </td>
            <td> {{$val->total}} </td>
            <td> {{$val->status_name}} </td>
            <td> 
              <a href="#" onclick="info('{{$uuid}}')">  
              <span class="glyphicon glyphicon-file"
              style="cursor:pointer" 
              title="detail {{$val['name']}}" 
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


  <script type="text/javascript">
    $.ajaxSetup({
      headers: {
          'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
      }
    });

    function reset_filter() {
      window.location = "{{route('invoice.index')}}";
    }
  </script>
  @include('invoice.modal_info_invoice')
@endsection

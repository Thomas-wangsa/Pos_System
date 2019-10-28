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
        <select class="form-control" name="search_sales">
          <option value=""> Filter By Sales </option>
          @foreach($data['sales'] as $key=>$val)
          <option value="{{$val->id}}"
            @if($val->id == Request::get('search_sales')) 
              selected
            @endif  
            > {{$val->name}} 
          </option>
          @endforeach
        </select>
      </div>

      <div class="form-group">
        <select class="form-control" name="search_customer">
          <option value=""> Filter By Customer </option>
          @foreach($data['customer'] as $key=>$val)
            <option value="{{$val->id}}"
            @if($val->id == Request::get('search_customer')) 
              selected
            @endif  
            > {{$val->name}} 
            </option>
          @endforeach
        </select>
      </div>

      <br/> <br/>

      <div class="form-group">
        <select class="form-control" name="search_po">
          <option value=""> Filter By PO </option>
          @foreach($data['po'] as $key=>$val)
            <option value="{{$val->id}}"
            @if($val->id == Request::get('search_po')) 
              selected
            @endif  
            > {{$val->number}} 
            </option>
          @endforeach
        </select>
      </div>

      
     
      <div class="form-group">
        <select class="form-control" name="search_status">
          <option value=""> Filter By Status </option>
          @foreach($data['invoice_status'] as $key=>$val)
            <option value="{{$val->id}}"
            @if($val->id == Request::get('search_status')) 
              selected
            @endif  
            > {{$val->name}} 
            </option>
          @endforeach
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
        <th> Payment Method </th>
        <th> Due Date </th>
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
            <td> {{$val->sales_name}} </td>
            <td> {{$val->customer_name}}} </td>
            <td> {{$val->total}} </td>
            <td> {{$val->payment_method_name}} </td>
            <td>  {{$val->due_date}} </td>
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

              @if($val->status == 3)
              <a href="#" onclick="update_invoice_status('{{$uuid}}')">
                <span class="glyphicon glyphicon-check"
                style="cursor:pointer;color:red" 
                title="set flag PO {{$val['number']}}"  
                >
                </span>
              </a> 
              @endif
            </td>
          </tr> 
          @endforeach
        @endif
    </tbody>
  </table>
  <div class="pull-right" style="margin-top: -15px!important"> 
    {{ $data['invoice']->appends(
      [
      'search' => Request::get('search'),
      'search_nama' => Request::get('search_nama'),
      'search_sales' => Request::get('search_sales'),
      'search_customer' => Request::get('search_customer'),
      'search_sales' => Request::get('search_po'),

      'search_status' => Request::get('search_status')
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
      window.location = "{{route('invoice.index')}}";
    }
  </script>
  @include('invoice.modal_info_invoice')
  @include('invoice.modal_update_invoice')
@endsection

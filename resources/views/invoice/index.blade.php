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
        <th> Customer </th>
        <th> PO </th>
        <th> Driver </th>
        <th> Status </th>
        <th> Action </th>
      </tr>
    </thead>
    <tbody>
       
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
@endsection

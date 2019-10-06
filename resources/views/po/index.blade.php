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
      <button type="button" class="btn btn-md btn-primary" data-toggle="modal" data-target="#modal_select_customer">
        <span class="glyphicon glyphicon-plus"></span>
        New PO
      </button>
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
            {{$key+1}}
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
              title="detail {{$val['name']}}" 
              >
              </span>
            </a>
            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;

            <a href="{{route('po.edit',$uuid)}}">
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
              >
              </span>
            </a> 
            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;

            <a href="{{route('do.create')}}?po_uuid={{$val['uuid']}}">  
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
</script>

  @include('po.modal_select_customer')
  @include('po.modal_info_po')
@endsection

@extends('layouts.main')

@section('content')

  <div style="margin-top: 15px">
    <div class="pull-left">
      <a href="{{route('do.create')}}">
        <button type="button" class="btn btn-md btn-primary">
          <span class="glyphicon glyphicon-plus"></span>
          New Delivery Order
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
        <th> Number </th>
        <th> PO </th>
        <th> Driver </th>
        <th> Status </th>
        <th> Action </th>
      </tr>
    </thead>
    <tbody>
       @if (count($data['do']) == 0 ) 
      <td colspan="10" class="text-center"> 
        No DO Found! 
      </td>
      @else
        @foreach($data['do'] as $key=>$val)
        <?php $uuid = $val["uuid"];?>
        <tr>
          <td>
            {{$key+1}}
          </td>
          <td>
            {{$val['number']}}
          </td>
          <td>
            {{$val['po_number']}}
          </td>
          <td>
            {{$val['driver_name']}}
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

            <a href="#">
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

          </td>
        </tr>
        @endforeach
      @endif
    </tbody>
  </table>
@endsection

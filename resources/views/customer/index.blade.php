@extends('layouts.main')

@section('content')
  <div style="margin-top: 15px">
    <div class="pull-left">
      <a href="{{route('customer.create')}}">
        <button type="button" class="btn btn-md btn-primary">
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
        <th> Category </th>
        <th> Sales </th>
        <th> Phone </th>
        <th> Owner </th>
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
            {{$key+1}}
          </td>
          <td>
            {{$val['name']}}
          </td>
          <td>
            {{$val['category_name']}}
          </td>
          <td>
            {{$val['sales_name']}}
          </td>
          
          <td>
            {{$val['phone']}}
          </td>
          <td>
            {{$val['owner']}}
          </td>
          
          <td>
              
            <a href="#">  
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

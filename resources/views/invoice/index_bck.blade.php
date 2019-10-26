@extends('layouts.main')

@section('content')
  <div style="margin-top: 15px">
    <div class="pull-left">
      <button type="button" class="btn btn-md btn-primary" data-toggle="modal" data-target="#modal_select_po">
        <span class="glyphicon glyphicon-plus"></span>
        New Invoice
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
        <th> PO </th>
        <th> Sales </th>
        <th> Total </th>
        <th> Status </th>
        <th> Action </th>
      </tr>
    </thead>
    <tbody>
       @if (count($data['invoice']) == 0 ) 
      <td colspan="10" class="text-center"> 
        No DO Found! 
      </td>
      @else
        @foreach($data['invoice'] as $key=>$val)
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
            {{$val['sales_name']}}
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

  @include('invoice.modal_info_invoice')

@endsection

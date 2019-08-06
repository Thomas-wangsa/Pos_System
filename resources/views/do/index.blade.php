@extends('layouts.main')

@section('content')
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
        <th> Customer </th>
        <th> Name </th>
        <th> Date </th>
        <th> Status </th>
        <th> Note </th>
        <th> Action </th>
      </tr>
    </thead>
    <tbody>
       @if (count($data['do']) == 0 ) 
      <td colspan="10" class="text-center"> 
        No PO Found! 
      </td>
      @else
      @endif
    </tbody>
  </table>

  @include('po.modal_select_customer')
@endsection

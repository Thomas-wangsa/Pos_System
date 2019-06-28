@extends('layouts.main')

@section('content')
  <div style="margin-top: 15px">
    <div class="pull-left">
      <a href="{{route('user.create')}}">
        <button type="button" class="btn btn-md btn-primary">
          add new user
        </button>
      </a>
    </div>
    <div class="clearfix"> </div>
  </div>

  <div class="pull-left">
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


  <table class="table table-bordered table-responsive">
    <thead>
      <tr>
        <th> No </th>
        <th> Name </th>
        <th> Email </th>
        <th style="min-width: 120px"> Action </th>
      </tr>
    </thead>
    <tbody>
      @if (count($data['users']) == 0 ) 
      <td colspan="10" class="text-center"> 
        No User Found! 
      </td>
      @else 
        @foreach($data['users'] as $key=>$val)
        <tr>
          <td>
            {{$key}}
          </td>
          <td>
            {{$val['name']}}
          </td>
          <td>
            {{$val['email']}}
          </td>
          <td>
          </td>
        </tr>
        @endforeach
      @endif
    </tbody>
  </table>
@endsection

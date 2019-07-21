@extends('layouts.main')

@section('content')

  <div style="margin: 10px auto">
    <a href="{{route('customer.index')}}">
      <button type="button" class="btn btn-md btn-warning">
        <span class="glyphicon glyphicon-chevron-left "></span>
        Back
      </button>
    </a>
  </div>
  <form action="{{route('customer.store')}}" method="POST">
    {{ csrf_field() }}

    <div class="form-group">
      <label for="sel1">Category:</label>
      <select class="form-control" id="sel1" name="category" required="">
        <option value=""> Select category </option>
        @foreach($data['category'] as $key=>$val)
        <option value="{{$val['id']}}"> {{$val['name']}} </option>
        @endforeach
      </select>
    </div>

    <div class="form-group">
      <label for="sel1">Sales:</label>
      <select class="form-control" id="sel1" name="sales">
        <option value=""> Select sales </option>
        @foreach($data['sales'] as $key=>$val)
        <option value="{{$val['id']}}"> {{$val['name']}} </option>
        @endforeach
      </select>
    </div>

    <div class="form-group">
      <label for="pwd"> Customer Name : </label>
      <input type="text" class="form-control" id="pwd"  name="name" required=""
      value="@if(env('ENV_STATUS', 'development') == 'development'){{$data['faker']->company}} @endif">
    </div>

    <div class="form-group">
      <label for="pwd"> Mobile :</label>
      <input type="text" class="form-control" id="pwd"  name="phone" required=""
      value="@if(env('ENV_STATUS', 'development') == 'development'){{$data['faker']->phoneNumber}} @endif">
    </div>


    <div class="form-group">
      <label for="pwd"> Owner : </label>
      <input type="text" class="form-control" id="pwd"  name="owner"
      value="@if(env('ENV_STATUS', 'development') == 'development'){{$data['faker']->name}} @endif">
    </div>

    <div class="form-group">
      <label for="pwd"> Relation From : </label>
      <input type="text" class="form-control" id="pwd"  name="relation_at"
      value="@if(env('ENV_STATUS', 'development') == 'development'){{$data['faker']->date}} @endif">
    </div>

    <div class="form-group">
      <label for="pwd"> Address : </label>
      <input type="text" class="form-control" id="pwd"  name="address"
      value="@if(env('ENV_STATUS', 'development') == 'development'){{$data['faker']->address}} @endif">
    </div>


    <div class="form-group">
      <label for="pwd"> Additional Note : </label>
      <input type="text" class="form-control" id="pwd"  name="note"
      value="@if(env('ENV_STATUS', 'development') == 'development'){{$data['faker']->text}} @endif">
    </div>


    <div class="text-center">
      <button type="submit" class="btn btn-primary btn-block">
        Add New Customer
      </button>
    </div>
  </form>
@endsection

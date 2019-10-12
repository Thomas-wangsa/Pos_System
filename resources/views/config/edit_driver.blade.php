@extends('layouts.main')

@section('content')

  <div style="margin: 10px auto">
    <a href="{{route('config.index')}}">
      <button type="button" class="btn btn-md btn-warning">
        <span class="glyphicon glyphicon-chevron-left "></span>
        Back
      </button>
    </a>
  </div>
  <form action="{{route('config.update_driver')}}" method="POST">
    {{ csrf_field() }}

    <input type="hidden" name="uuid" value="{{$data['driver']->uuid}}">
    <div class="form-group">
      <label for="sel1"> Type :</label>
      <select class="form-control" id="sel1" disabled="">
        <option value=""> Driver </option>
      </select>
    </div>

    <div class="form-group">
      <label for="pwd"> Name : </label>
      <input type="text" class="form-control" id="pwd"  name="name" required=""
      value="{{$data['driver']->name}}">
    </div>

    <div class="form-group">
      <label for="pwd"> Detail :</label>
      <input type="text" class="form-control" id="pwd"  name="detail" required=""
      value="{{$data['driver']->detail}}">
    </div>


    <div class="text-center">
      <button type="submit" class="btn btn-primary btn-block">
        Update Driver
      </button>
    </div>
  </form>
@endsection

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
  <form action="{{route('config.update_config')}}" method="POST">
    {{ csrf_field() }}

    <input type="hidden" name="uuid" value="{{$data['category']->uuid}}">
    <div class="form-group">
      <label for="sel1"> Type :</label>
      <select class="form-control" id="sel1" disabled="">
        <option value=""> Category </option>
      </select>
    </div>

    <div class="form-group">
      <label for="pwd"> Name : </label>
      <input type="text" class="form-control" id="pwd"  name="name" required=""
      value="{{$data['category']->name}}">
    </div>

    <div class="form-group">
      <label for="pwd"> Detail :</label>
      <input type="text" class="form-control" id="pwd"  name="detail" required=""
      value="{{$data['category']->detail}}">
    </div>


    <div class="text-center">
      <button type="submit" class="btn btn-primary btn-block">
        Update Category
      </button>
    </div>
  </form>
@endsection

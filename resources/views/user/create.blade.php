@extends('layouts.main')

@section('content')
  <form action="{{route('user.store')}}" method="POST">
    {{ csrf_field() }}
    <div class="form-group">
      <label for="pwd"> Name : </label>
      <input type="text" class="form-control" id="pwd"  name="name" required="">
    </div>

    <div class="form-group">
      <label for="pwd">email :</label>
      <input type="email" class="form-control" id="pwd"  name="email" required="">
    </div>
    <div class="text-center">
      <button type="submit" class="btn btn-primary btn-block">
        Add New User
      </button>
    </div>
  </form>
@endsection

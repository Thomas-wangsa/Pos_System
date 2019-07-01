@extends('layouts.main')

@section('content')
  <form action="{{route('user.store')}}" method="POST">
    {{ csrf_field() }}
    <div class="form-group">
      <label for="pwd"> Name : </label>
      <input type="text" class="form-control" id="pwd"  name="name" required="">
    </div>

    <div class="form-group">
      <label for="pwd">Email :</label>
      <input type="email" class="form-control" id="pwd"  name="email" required="">
    </div>

    <div class="form-group">
      <label for="pwd"> Phone : </label>
      <input type="text" class="form-control" id="pwd"  name="phone">
    </div>

    <div class="form-group">
      <label for="sel1">Select role :</label>
      <select class="form-control" name="role" id="sel1" required="">
        <option>Select Role</option>
        <option value="1">Admin</option>
        <option value="2">Owner</option>
        <option value="3">Sales</option>
      </select>
    </div>

    <div class="form-group">
      <label for="pwd"> Password : </label>
      <input type="password" class="form-control" id="pwd"  name="password" required="">
    </div>

    

    <div class="text-center">
      <button type="submit" class="btn btn-primary btn-block">
        Add New User
      </button>
    </div>
  </form>
@endsection

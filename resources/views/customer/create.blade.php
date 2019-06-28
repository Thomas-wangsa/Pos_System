@extends('layouts.main')

@section('content')
  <form action="{{route('customer.store')}}" method="POST">
    {{ csrf_field() }}

    <div class="form-group">
    <label for="sel1">Category:</label>
    <select class="form-control" id="sel1" name="category" required="">
      <option> Select category </option>
      @foreach($data['category'] as $key=>$val)
      <option value="{{$val['id']}}"> {{$val['name']}} </option>
      @endforeach
    </select>
  </div>

    <div class="form-group">
      <label for="pwd"> Name : </label>
      <input type="text" class="form-control" id="pwd"  name="name" required="">
    </div>

    <div class="form-group">
      <label for="pwd"> Mobile :</label>
      <input type="text" class="form-control" id="pwd"  name="mobile" required="">
    </div>
    <div class="text-center">
      <button type="submit" class="btn btn-primary btn-block">
        Add New User
      </button>
    </div>
  </form>
@endsection

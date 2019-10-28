@extends('layouts.main')

@section('content')
  
  <?php $set_passwd = 123456; ?>
  <div style="margin: 10px auto">
    <a href="{{route('user.index')}}">
      <button type="button" class="btn btn-md btn-info">
        <span class="glyphicon glyphicon-chevron-left "></span>
        Back
      </button>
    </a>
  </div>

  <form action="{{route('user.update',$data['user']->uuid)}}" method="POST">
    {{ csrf_field() }}
    <input type="hidden" name="_method" value="PUT">


    <div class="form-group">
      <label for="pwd"> Name : </label>
      <input type="text" class="form-control" id="pwd"  name="name" maxlength="40" required=""
      value="{{$data['user']->name}}">
    </div>

    <div class="form-group">
      <label for="pwd">Email :</label>
      <input type="email" class="form-control" id="pwd"  name="email" required=""
      value="{{$data['user']->email}}">
    </div>

    <div class="form-group">
      <label for="pwd"> Phone : </label>
      <input type="text" class="form-control" id="pwd"  name="phone" maxlength="100"
      value="{{$data['user']->phone}}">
    </div>

    @if(Auth::user()->role == 1)
    <div class="form-group">
      <label for="sel1">Select role :</label>
      <select class="form-control" name="role" id="sel1" required="">
        <option value="">Select Role</option>
        @foreach($data['user_role'] as $val)
        <option value="{{$val['id']}}"
        <?php if(Auth::user()->role == $val['id']) { echo "selected"; } ?>
        > 
          {{$val['name']}}
        </option>
        @endforeach
      </select>
    </div>

    <div class="form-group">
      <label for="pwd"> Password : </label>
      <input type="password" class="form-control" id="pwd"  name="password" maxlength="25" 
      value="">
    </div>
    @endif



    <div class="text-center" style="margin-top: 50px">
      <button type="submit" class="btn btn-info btn-block">
        <span class="glyphicon glyphicon-plus"></span> Update Users
      </button>
    </div>
  </form>
@endsection

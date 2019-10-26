@extends('layouts.main')

@section('content')
  
  @foreach (['danger', 'warning', 'success', 'info'] as $msg)
      @if(Session::has('alert-' . $msg))

      <p class="alert alert-{{ $msg }}">{{ Session::get('alert-' . $msg) }} 
        <a href="#" class="close" data-dismiss="alert" aria-label="close">
          &times;
        </a>
     </p>
      @endif
  @endforeach
  
  <?php $set_passwd = 123456; ?>
  <div style="margin: 10px auto">
    <a href="{{route('user.index')}}">
      <button type="button" class="btn btn-md btn-warning">
        <span class="glyphicon glyphicon-chevron-left "></span>
        Back
      </button>
    </a>
  </div>

  <form action="{{route('user.store')}}" method="POST">
    {{ csrf_field() }}
    <div class="form-group">
      <label for="pwd"> Name : </label>
      <input type="text" class="form-control" id="pwd"  name="name" maxlength="40" required=""
      value="@if(env('ENV_STATUS', 'development') == 'development'){{$data['faker']->name}} @endif">
    </div>

    <div class="form-group">
      <label for="pwd">Email :</label>
      <input type="email" class="form-control" id="pwd"  name="email" required=""
      value="@if(env('ENV_STATUS', 'development') == 'development'){{$data['faker']->email}} @endif">
    </div>

    <div class="form-group">
      <label for="pwd"> Phone : </label>
      <input type="text" class="form-control" id="pwd"  name="phone" maxlength="100"
      value="@if(env('ENV_STATUS', 'development') == 'development'){{$data['faker']->phoneNumber}} @endif">
    </div>

    <div class="form-group">
      <label for="sel1">Select role :</label>
      <select class="form-control" name="role" id="sel1" required="">
        <option value="">Select Role</option>
        @foreach($data['user_role'] as $val)
        <option value="{{$val['id']}}"> {{$val['name']}}</option>
        @endforeach
      </select>
    </div>

    <div class="form-group">
      <label for="pwd"> Password : </label>
      <input type="password" class="form-control" id="pwd"  name="password" maxlength="25" required=""
      value="@if(env('ENV_STATUS', 'development') == 'development'){{$set_passwd}}@endif">
    </div>

    <div class="form-group">
      <label for="pwd"> Repeat Password : </label>
      <input type="password" class="form-control" id="re_pwd"  name="re_password" maxlength="25" required=""
      value="@if(env('ENV_STATUS', 'development') == 'development') {{$set_passwd}} @endif">
    </div>

    <div class="text-center" style="margin-top: 50px">
      <button type="submit" class="btn btn-primary btn-block">
        <span class="glyphicon glyphicon-plus"></span> New Users
      </button>
    </div>
  </form>
@endsection

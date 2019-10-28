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
  <form action="{{route('customer.update',$data['customer']->uuid)}}" method="POST">
    {{ csrf_field() }}
    <input type="hidden" name="_method" value="PUT">

    <div class="form-group">
      <label for="sel1">Sales:</label>
      <select class="form-control" id="sel1" name="sales">
        <option value=""> Select sales </option>
        @foreach($data['sales'] as $key=>$val)
        <option value="{{$val['id']}}"
        <?php if($data['customer']->sales_id == $val['id']) { echo "selected"; } ?>
        > {{$val['name']}} </option>
        @endforeach
      </select>
    </div> 

    <div class="form-group">
      <label for="pwd"> Customer Name : </label>
      <input type="text" class="form-control" id="pwd"  name="name" required=""
      value="{{$data['customer']->name}}">
    </div>

    <div class="form-group">
      <label for="pwd"> Mobile :</label>
      <input type="text" class="form-control" id="pwd"  name="phone" required=""
      value="{{$data['customer']->phone}}">
    </div>


    <div class="form-group">
      <label for="pwd"> Owner : </label>
      <input type="text" class="form-control" id="pwd"  name="owner"
      value="{{$data['customer']->owner}}">
    </div>

    <div class="form-group">
      <label for="pwd"> Address : </label>
      <input type="text" class="form-control" id="pwd"  name="address"
      value="{{$data['customer']->address}}">
    </div>

    <div class="form-group">
      <label for="sel1">Status :</label>
      <select class="form-control" id="sel1" name="status">
        <option value=""> Select status </option>
        @foreach($data['status'] as $key=>$val)
        <option value="{{$val['id']}}"
        <?php if($data['customer']->status == $val['id']) { echo "selected"; } ?>
        > {{$val['name']}} </option>
        @endforeach
      </select>
    </div>
    
    <div class="form-group">
      <label for="pwd"> Relation From : </label>
      <input type="text" class="form-control datepicker_class" id="relation_at"  name="relation_at"
      value="{{$data['customer']->relation_at}}">
    </div>

    <div class="form-group">
      <label for="pwd"> Relation End : </label>
      <input type="text" class="form-control datepicker_class" id="relation_end"  name="relation_end"
      value="{{$data['customer']->relation_end}}">
    </div>

    <div class="form-group">
      <label for="pwd"> Additional Note : </label>
      <input type="text" class="form-control" id="pwd"  name="note"
      value="{{$data['customer']->note}}">
    </div>

    <div class="text-center">
      <button type="submit" class="btn btn-warning btn-block">
        Update Customer
      </button>
    </div>
  </form>
@endsection

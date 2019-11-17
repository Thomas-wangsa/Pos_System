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

  <form action="{{route('report.get_report')}}" method="POST">
    {{ csrf_field() }}
    <div class="form-group">
      <label for="email">From Date :</label>
      <input type="text" class="form-control datepicker_class" id="from_date" name="from_date" value="{{$data['from_date']}}" required=""> 
    </div>

    <div class="form-group">
      <label for="email">To Date :</label>
      <input type="text" class="form-control datepicker_class" id="to_date" name="to_date" value="{{$data['to_date']}}" required="">
    </div>

    <div class="form-group">
      <label for="email"> Sales : </label>
      <select class="form-control" name="search_sales">
        <option value=""> Filter By Sales </option>
        @foreach($data['sales'] as $key=>$val)
        <option value="{{$val['id']}}"> {{$val['name']}} </option>
        @endforeach
      </select>
    </div>

    <div class="form-group">
      <label for="email"> Customer : </label>
      <select class="form-control" name="search_customer">
        <option value=""> Filter By Customer </option>
        @foreach($data['customer'] as $key=>$val)
        <option value="{{$val['id']}}"> {{$val['name']}} </option>
        @endforeach
      </select>
    </div>


    <div class="text-center" style="margin-top: 50px">
      <button type="submit" class="btn btn-primary btn-block">
        Get Report
      </button>
    </div>
  </form>
     
@endsection

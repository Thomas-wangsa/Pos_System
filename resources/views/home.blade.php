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


    <div class="col-md-3">
      <div class="thumbnail">
        <a href="{{route('user.index')}}">
          <div class="icon_block">
                <span class="glyphicon glyphicon-user ">
                </span> &nbsp;
          </div>
          <div class="caption text-center">
            <p> User</p>
          </div>
        </a>
      </div>
    </div>

    <div class="col-md-3">
      <div class="thumbnail">
        <a href="{{route('customer.index')}}">

          <div class="icon_block">
                <span class="glyphicon glyphicon-book">
                </span> &nbsp;
          </div>
          <div class="caption text-center">
            <p> Customer </p>
          </div>
        </a>
      </div>
    </div>

    <div class="col-md-3">
      <div class="thumbnail">
        <a href="{{route('po.index')}}">

          <div class="icon_block">
                <span class="glyphicon glyphicon-file ">
                </span> &nbsp;
          </div>
          <div class="caption text-center">
            <p> PO </p>
          </div>
        </a>
      </div>
    </div>


    <div class="col-md-3">
      <div class="thumbnail">
        <a href="{{route('do.index')}}">

          <div class="icon_block">
                <span class="glyphicon glyphicon-envelope">
                </span> &nbsp;
          </div>
          <div class="caption text-center">
            <p> DO </p>
          </div>
        </a>
      </div>
    </div>


    <div class="col-md-3">
      <div class="thumbnail">
        <a href="{{route('invoice.index')}}">

          <div class="icon_block">
                <span class="glyphicon glyphicon-usd">
                </span> &nbsp;
          </div>
          <div class="caption text-center">
            <p> Invoice </p>
          </div>
        </a>
      </div>
    </div>

    <div class="col-md-3">
      <div class="thumbnail">
        <a href="{{route('config.index')}}">

          <div class="icon_block">
                <span class="glyphicon glyphicon-folder-open">
                </span> &nbsp;
          </div>
          <div class="caption text-center">
            <p> Report </p>
          </div>
        </a>
      </div>
    </div>


    <div class="col-md-3">
      <div class="thumbnail">
        <a href="{{route('config.index')}}">

          <div class="icon_block">
                <span class="glyphicon glyphicon-cog">
                </span> &nbsp;
          </div>
          <div class="caption text-center">
            <p> Config </p>
          </div>
        </a>
      </div>
    </div>

    <div class="col-md-3">
      <div class="thumbnail">
        <a href="{{route('profile.index')}}">

          <div class="icon_block">
                <span class="glyphicon glyphicon-edit">
                </span> &nbsp;
          </div>
          <div class="caption text-center">
            <p> Profile </p>
          </div>
        </a>
      </div>
    </div>


@endsection

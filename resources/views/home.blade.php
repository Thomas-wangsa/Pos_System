@extends('layouts.main')

@section('content')
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
                <span class="glyphicon glyphicon-user ">
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
                <span class="glyphicon glyphicon-file ">
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
        <a href="/w3images/nature.jpg">

          <div class="icon_block">
                <span class="glyphicon glyphicon-file">
                </span> &nbsp;
          </div>
          <div class="caption text-center">
            <p>Lorem ipsum...</p>
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


@endsection

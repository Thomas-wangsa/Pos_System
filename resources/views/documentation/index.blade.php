@extends('layouts.main')

@section('content')
  
  <div class="panel-group">
    <div class="panel panel-default">
      <div class="panel-heading">
        <h4 class="panel-title">
          <a data-toggle="collapse" href="#collapse1"> Authorization Level </a>
        </h4>
      </div>
      <div id="collapse1" class="panel-collapse collapse">
        <ul class="list-group">
          <li class="list-group-item">Owner : Super User on this system, can do anything </li>
          <li class="list-group-item">Admin</li>
          <li class="list-group-item">Sales</li>
        </ul>
        <div class="panel-footer">Footer</div>
      </div>
    </div>
  </div>
@endsection

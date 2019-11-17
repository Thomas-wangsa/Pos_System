
@extends('layouts.main')
@section('content')
    
    <div style="margin: 10px auto">
    <a href="{{route('report.index')}}">
      <button type="button" class="btn btn-md btn-warning">
        <span class="glyphicon glyphicon-chevron-left "></span>
        Back
      </button>
    </a>
    </div>

    <div id="piechart" style="width: 900px; height: 500px;"></div>




    <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
    <script type="text/javascript">
      google.charts.load('current', {'packages':['corechart']});
      google.charts.setOnLoadCallback(drawChart);

      function drawChart() {

        var data = google.visualization.arrayToDataTable([
          ['Status', 'Total'],
          @foreach($data['report'] as $key=>$val)
          ["{{$val->status}}" , {{$val->total}}],
          @endforeach

        ]);

        var options = {
          title: "{{$data['title']}}"
        };

        var chart = new google.visualization.PieChart(document.getElementById('piechart'));

        chart.draw(data, options);
      }
    </script>

@endsection


    

<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
<head>


   <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>



  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.0/css/bootstrap.min.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.0/jquery.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.0/js/bootstrap.min.js"></script>





  <style>
    /* Set height of the grid so .sidenav can be 100% (adjust if needed) */
    .row.content {height: 1200px}
    
    /* Set gray background color and 100% height */
    .sidenav {
      background-color: #f1f1f1;
      height: 100%;
    }
    
    /* Set black background color, white text and some padding */
    footer {
      background-color: #555;
      color: white;
      padding: 15px;
    }
    
    /* On small screens, set height to 'auto' for sidenav and grid */
    @media screen and (max-width: 767px) {
      .sidenav {
        height: auto;
        padding: 15px;
      }
      .row.content {height: auto;} 
    }

    .icon_block {
        margin-top : 20px;
        text-align: center;
        /*background-color: tomato;*/
    }



    .icon_block span {
        font-size: 100px;
    }
  </style>
</head>
<body>

  <div class="full_wrapper" style="max-width: 3000px;margin: 0 auto">

    <header class="container-fluid">
      <div class="row">
        <nav class="navbar navbar-inverse" style="margin-bottom: 0px">
          <div class="container-fluid">
            <div class="navbar-header">
              <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#myNavbar">
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span> 
              </button>
              <a class="navbar-brand" href="/home">WebSiteName</a>
            </div>
            <div class="collapse navbar-collapse" id="myNavbar">
              <ul class="nav navbar-nav">
                <li class="active"><a href="#">Home</a></li>
                <li><a href="#">Page 1</a></li>
                <li><a href="#">Page 2</a></li> 
                <li><a href="#">Page 3</a></li> 
              </ul>
              <ul class="nav navbar-nav navbar-right">
                <li><a href="#"><span class="glyphicon glyphicon-user"></span> Sign Up</a></li>
                <li><a href="#"><span class="glyphicon glyphicon-log-in"></span> Login</a></li>
              </ul>
            </div>
          </div>
        </nav>
      </div>
    </header>


    <div class="body_wrapper" >
      <div class="container-fluid">
        <div class="row content">
          
          <div class="col-sm-3 sidenav" style="padding-top: 15px">
            <h4>John's Blog</h4>
            <ul class="nav nav-pills nav-stacked">
              <li class="active"><a href="#section1">Home</a></li>
              <li><a href="#section2">Friends</a></li>
              <li><a href="#section3">Family</a></li>
              <li><a href="#section3">Photos</a></li>
            </ul><br>
            <div class="input-group">
              <input type="text" class="form-control" placeholder="Search Blog..">
              <span class="input-group-btn">
                <button class="btn btn-default" type="button">
                  <span class="glyphicon glyphicon-search"></span>
                </button>
              </span>
            </div>
          </div>

          <div class="col-sm-9" style="padding-top: 20px">
            
          
              <div style="margin-top: 15px">
                <div class="pull-left">
                  <a href="{{route('po.create')}}">
                    <button type="button" class="btn btn-md btn-primary">
                      add new po
                    </button>
                  </a>
                </div>
                <div class="clearfix"> </div>
              </div>


              <div class="pull-left">
                <form class="form-inline" action="">
                  <input type="hidden" name="search" value="on"> </input>
                  <div class="form-group">
                    <div class="input-group">
                      <span class="input-group-addon">
                        <i class="glyphicon glyphicon-search">
                        </i>
                      </span>
                      <input type="text" class="form-control" 
                      name="search_nama" placeholder="Find Name..."
                      value="{{Request::get('search_nama')}}">
                    </div>
                  </div>
                  
                  <div class="form-group">
                    <select class="form-control" name="search_filter">
                      <option value=""> Filter By </option>
                    </select>
                  </div>

                  <div class="form-group">
                      <select class="form-control" name="search_order">
                        <option value=""> Sort By </option>
                      </select>
                  </div>
                
                  <button type="submit" class="btn btn-info"> 
                    Filter
                  </button> 
                </form>
              </div>
              <div class="clearfix"> </div>


              <table class="table table-bordered table-responsive">
                <thead>
                  <tr>
                    <th> No </th>
                    <th> customer </th>
                    <th> internal </th>
                    <th> external </th>
                    <th style="min-width: 120px"> Action </th>
                  </tr>
                </thead>
                <tbody>
                  @if (count($data['po']) == 0 ) 
                  <td colspan="10" class="text-center"> 
                    No PO Found! 
                  </td>
                  @else 
                    @foreach($data['po'] as $key=>$val)
                    <tr>
                      <td>
                        {{$key}}
                      </td>
                      <td>
                        {{$val['customer_id']}}
                      </td>
                      <td>
                        {{$val['internal_code']}}
                      </td>
                      <td>
                        {{$val['external_code']}}
                      </td>
                      <td>
                      </td>
                    </tr>
                    @endforeach
                  @endif
                </tbody>
              </table>



          </div> <!-- col9 -->

        </div>
      </div>
    </div> <!-- body-->

    <footer class="container-fluid">
      <p>Footer Text</p>
    </footer>
  </div>

</body>
</html>

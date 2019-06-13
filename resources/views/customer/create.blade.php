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
            
          
            <form action="{{route('customer.store')}}" method="POST">
              {{ csrf_field() }}
              <div class="form-group">
                <label for="pwd"> Category : </label>
                <input type="text" class="form-control" id="pwd"  name="category" required="">
              </div>

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

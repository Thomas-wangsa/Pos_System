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
          <a class="navbar-brand" href="{{route('home')}}"> Putra System </a>
        </div>
        <div class="collapse navbar-collapse" id="myNavbar">
          <ul class="nav navbar-nav">
            <li class="active"><a href="#">Home</a></li>
            <li><a href="#">Page 1</a></li>
            <li><a href="#">Page 2</a></li> 
            <li><a href="#">Page 3</a></li> 
          </ul>
          <ul class="nav navbar-nav navbar-right">
            
            <li>
              <a href="#" class="dropdown-toggle" 
              data-toggle="dropdown" role="button" aria-expanded="false" aria-haspopup="true" v-pre>
                <span class="glyphicon glyphicon-user"></span> 
                &nbsp;
                {{ ucfirst(Auth::user()->name) }} 
                &nbsp;&nbsp;<span class="caret"></span>
              </a>

              <ul class="dropdown-menu">
                <li>
                  <a href="{{ route('logout') }}">
                    <span class="glyphicon glyphicon-envelope"></span>
                    Profile
                  </a>

                </li>
                <li>
                  <a href="{{ route('logout') }}">
                    <span class="glyphicon glyphicon-edit"></span>
                    Password
                  </a>

                </li>
              </ul>
            </li>
            <li><a href="{{route('logout')}}"><span class="glyphicon glyphicon-log-out"></span> Logout</a></li>
          </ul>
        </div>
      </div>
    </nav>
  </div>
</header>
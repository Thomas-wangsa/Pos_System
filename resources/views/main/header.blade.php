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
            
            <li class="active">
              <a href="{{route('home')}}">
                Home
              </a>
            </li>
            
            <li>
              <a href="{{route('user.index')}}">
                User
              </a>
            </li>

            <li>
              <a href="{{route('customer.index')}}">
                Customer
              </a>
            </li>

            <li>
              <a href="#" class="dropdown-toggle" 
              data-toggle="dropdown" role="button" aria-expanded="false" aria-haspopup="true" v-pre>
                <span class="glyphicon glyphicon-user"></span> 
                Data
                <span class="caret"></span>
              </a>

              <ul class="dropdown-menu">
                <li>
                  <a href="{{ route('po.index') }}">
                    <span class="glyphicon glyphicon-envelope"></span>
                    PO
                  </a>
                </li>
                <li>
                  <a href="{{ route('do.index') }}">
                    <span class="glyphicon glyphicon-edit"></span>
                    Delivery Order
                  </a>
                </li>

                <li>
                  <a href="{{ route('invoice.index') }}">
                    <span class="glyphicon glyphicon-edit"></span>
                    Invoice
                  </a>
                </li>
              </ul>
            </li>




            <li><a href="#"> Report </a></li> 
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
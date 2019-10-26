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
                        
            <li class="@if(Route::current()->getName() == 'user.index') echo active @endif">
              <a href="{{route('user.index')}}">
                <span class="glyphicon glyphicon-user"></span> 
                User
              </a>
            </li>

            <li class="@if(Route::current()->getName() == 'customer.index') echo active @endif">
              <a href="{{route('customer.index')}}">
                <span class="glyphicon glyphicon-book"></span> 
                Customer
              </a>
            </li>

            <li 
            class="@if(Route::current()->getName() == 'po.index' OR 
            Route::current()->getName() == 'do.index' OR
            Route::current()->getName() == 'invoice.index' ) 
            echo active @endif" 
            >
              <a href="#" class="dropdown-toggle" 
              data-toggle="dropdown" role="button" aria-expanded="false" aria-haspopup="true" v-pre>
                Data
                <span class="caret"></span>
              </a>

              <ul class="dropdown-menu">
                <li>
                  <a href="{{ route('po.index') }}">
                    <span class="glyphicon glyphicon-file"></span>
                    PO
                  </a>
                </li>
                <li>
                  <a href="{{ route('do.index') }}">
                    <span class="glyphicon glyphicon-envelope"></span>
                    Delivery Order
                  </a>
                </li>

                <li>
                  <a href="{{ route('invoice.index') }}">
                    <span class="glyphicon glyphicon-usd"></span>
                    Invoice
                  </a>
                </li>
              </ul>
            </li>




            <li>
              <a href="#">
                <span class="glyphicon glyphicon-folder-open"></span> 
                Report 
              </a>
            </li> 
            
            <li>
              <a href="{{ route('config.index') }}">
                <span class="glyphicon glyphicon-cog"></span>
                Config
              </a>
            </li>


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
                  <a href="{{ route('profile.index') }}">
                    <span class="glyphicon glyphicon-edit"></span>
                    Profile
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
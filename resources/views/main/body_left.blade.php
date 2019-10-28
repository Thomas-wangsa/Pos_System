<div class="col-sm-2 sidenav" style="padding-top: 15px">
  <ul class="nav nav-pills nav-stacked">
    
    <li class="@if(Route::current()->getName() == 'home') echo active @endif">
      <a href="{{route('home')}}">
        <span class="glyphicon glyphicon-home">
        Home
      </a>
    </li>

    <li class="@if(Route::current()->getName() == 'user.index') echo active @endif">
      <a href="{{route('user.index')}}">
        <span class="glyphicon glyphicon-user">
        Users
      </a>
    </li>

    <li class="@if(Route::current()->getName() == 'customer.index') echo active @endif">
      <a href="{{route('customer.index')}}">
        <span class="glyphicon glyphicon-book">
        Customers
      </a>
    </li>

    <li class="@if(Route::current()->getName() == 'po.index') echo active @endif">
      <a href="{{route('po.index')}}">
        <span class="glyphicon glyphicon-book">
        PO
      </a>
    </li>

    <li class="@if(Route::current()->getName() == 'do.index') echo active @endif">
      <a href="{{route('do.index')}}">
        <span class="glyphicon glyphicon-envelope">
        Delivery Order
      </a>
    </li>

    <li class="@if(Route::current()->getName() == 'invoice.index') echo active @endif">
      <a href="{{route('invoice.index')}}">
        <span class="glyphicon glyphicon-usd">
        Invoice
      </a>
    </li>

    <li class="@if(Route::current()->getName() == 'config.index') echo active @endif">
      <a href="{{route('report.index')}}">
        <span class="glyphicon glyphicon-folder-open">
        Report
      </a>
    </li>

     <li class="@if(Route::current()->getName() == 'config.index') echo active @endif">
      <a href="{{route('config.index')}}">
        <span class="glyphicon glyphicon-cog">
        Config
      </a>
    </li>


    <li class="@if(Route::current()->getName() == 'profile.index') echo active @endif">
      <a href="{{route('profile.index')}}">
        <span class="glyphicon glyphicon-edit">
        Profile
      </a>
    </li>


  </ul><br>

</div>
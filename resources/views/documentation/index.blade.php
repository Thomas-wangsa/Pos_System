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
          <li class="list-group-item">Sales : very limited access, only view limited data </li>
          <li class="list-group-item">Admin : can create users,customer,PO etc but limited to normal flow in system </li>
          <li class="list-group-item">Owner : super-user on this system, can do anything </li>
        </ul>
      </div>
    </div>



    <div class="panel panel-info">
      <div class="panel-heading">
        <h4 class="panel-title">
          <a data-toggle="collapse" href="#collapse2"> User Page </a>
        </h4>
      </div>
      <div id="collapse2" class="panel-collapse collapse">
        <ul class="list-group">
          <li class="list-group-item"> 
            User Page : list registered user's in the system
            <br/> <br/>
            sales : not available to user page. <br/> 
            admin : can view, filter and edit user-data. <br/> 
            owner : can view, filter, edit, deactivated & restore user-data.
          </li>

          <li class="list-group-item"> 
            Create New User Page.
            <br/> <br/>
            sales : not available to user page. <br/>
            admin : can create new user data, password & specific role <br/>
            owner : same like admin.
          </li>

          <li class="list-group-item"> 
            Edit User Page.
            <br/> <br/>
            sales : not available to user page. <br/>
            admin : can edit name, email & phone only <br/>
            owner : same like admin + edit password & changed role to owner 
          </li>
        </ul>
      </div>
    </div>



    <div class="panel panel-warning">
      <div class="panel-heading">
        <h4 class="panel-title">
          <a data-toggle="collapse" href="#collapse3"> Customer Page </a>
        </h4>
      </div>
      <div id="collapse3" class="panel-collapse collapse">
        <ul class="list-group">
          <li class="list-group-item"> 
            Customer Page.
            <br/> <br/>
            sales : can view & filter customer data that belong to himself. <br/> 
            admin : can view, filter, add, edit & auto-create PO by customer-data <br/> 
            owner : same like admin + deactivated & restore customer.
          </li>

          <li class="list-group-item"> 
            Create New Customer Page.
            <br/> <br/>
            sales : not available to this page. <br/> 
            admin : can create new customer-data <br/> 
            owner : same like admin.
          </li>

          <li class="list-group-item"> 
            Edit Customer Page.
            <br/> <br/>
            sales : not available to this page. <br/> 
            admin : can edit the customer-data <br/> 
            owner : same like admin.
          </li>

        </ul>
      </div>
    </div>


    <div class="panel panel-primary">
      <div class="panel-heading">
        <h4 class="panel-title">
          <a data-toggle="collapse" href="#collapse4"> Purchase Order Page </a>
        </h4>
      </div>
      <div id="collapse4" class="panel-collapse collapse">
        <ul class="list-group">
          <li class="list-group-item"> 
            PO Page.
            <br/> <br/>
            sales : can view & filter po data that belong to himself. <br/> 
            admin : can view, filter, add, edit, update status & auto-create Delivery-Order <br/> 
            owner : same like admin 
          </li>

          <li class="list-group-item"> 
            Create New PO Page.
            <br/> <br/>
            sales : not available to this page. <br/> 
            admin : can create new po-data <br/> 
            owner : same like admin.
          </li>

          <li class="list-group-item"> 
            Edit PO Page.
            <br/> <br/>
            sales : not available to this page. <br/> 
            admin : can edit the po-data <br/> 
            owner : same like admin.
          </li>

        </ul>
      </div>
    </div>



    <div class="panel panel-success">
      <div class="panel-heading">
        <h4 class="panel-title">
          <a data-toggle="collapse" href="#collapse5"> Delivery Order Page </a>
        </h4>
      </div>
      <div id="collapse5" class="panel-collapse collapse">
        <ul class="list-group">
          <li class="list-group-item"> 
            Delivery Order Page.
            <br/> <br/>
            sales : can view & filter delivery order data that belong to himself. <br/> 
            admin : can view, filter, add, edit, update status delivery order<br/> 
            owner : same like admin 
          </li>

          <li class="list-group-item"> 
            Create New Delivery Order Page.
            <br/> <br/>
            sales : not available to this page. <br/> 
            admin : can create new delivery-order-data <br/> 
            owner : same like admin.
          </li>

          <li class="list-group-item"> 
            Edit Delivery Order Page.
            <br/> <br/>
            sales : not available to this page. <br/> 
            admin : can edit the delivery-order-data <br/> 
            owner : same like admin.
          </li>

        </ul>
      </div>
    </div>


  </div>
@endsection

<link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
<script>
  $( function() {
    $(".datepicker_class" ).datepicker({
      dateFormat: 'yy-mm-dd' ,
      showButtonPanel: true
    });
  });
</script>

<div class="col-sm-10" style="padding-top: 0px">
	

	<div class="pull-left">
		<h3>
			@if(Route::current()->getName() == 'user.index')
			USER PAGE
			@elseif(Route::current()->getName() == 'user.create')
			CREATE NEW USER PAGE
			@elseif(Route::current()->getName() == 'user.edit')
			EDIT USER PAGE
			@elseif(Route::current()->getName() == 'customer.index')
			CUSTOMER PAGE
			@elseif(Route::current()->getName() == 'customer.create')
			CREATE NEW CUSTOMER PAGE
			@elseif(Route::current()->getName() == 'customer.edit')
			EDIT CUSTOMER PAGE
			@elseif(Route::current()->getName() == 'po.index')
			PO PAGE
			@elseif(Route::current()->getName() == 'po.create')
			CREATE NEW PO PAGE
			@elseif(Route::current()->getName() == 'po.edit')
			EDIT PO PAGE
			@elseif(Route::current()->getName() == 'config.index')
			CONFIG PAGE
			@elseif(Route::current()->getName() == 'config.edit_config')
			EDIT CATEGORY PAGE
			@elseif(Route::current()->getName() == 'config.edit_driver')
			EDIT DRIVER PAGE
			@elseif(Route::current()->getName() == 'do.index')
			DELIVERY ORDER PAGE
			@elseif(Route::current()->getName() == 'do.create')
			CREATE NEW DELIVERY ORDER PAGE
			@elseif(Route::current()->getName() == 'do.edit')
			EDIT DELIVERY ORDER PAGE
			@elseif(Route::current()->getName() == 'invoice.index')
			INVOICE PAGE
			@endif
			
		</h3>
	</div>

	<div class="clearfix"> </div>
	@yield('content')  
</div>
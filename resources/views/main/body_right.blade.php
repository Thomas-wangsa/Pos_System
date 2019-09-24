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

<div class="col-sm-9" style="padding-top: 0px">
	

	<div class="pull-left">
		<h3>
			@if(Route::current()->getName() == 'user.index')
			USER PAGE
			@elseif(Route::current()->getName() == 'user.create')
			CREATE NEW USER PAGE
			@elseif(Route::current()->getName() == 'user.edit')
			EDIT USER PAGE
			@endif
			
		</h3>
	</div>

	<div class="clearfix"> </div>
	@yield('content')  
</div>
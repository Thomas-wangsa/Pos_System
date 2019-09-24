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
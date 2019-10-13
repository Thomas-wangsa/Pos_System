@extends('layouts.main')

@section('content')
<style type="text/css">
	.main_section {margin-top: 20px}
</style>
	<div style="margin: 10px auto">
	    <a href="{{route('do.index')}}">
	      <button type="button" class="btn btn-md btn-warning">
	        <span class="glyphicon glyphicon-chevron-left "></span>
	        Back to Delivery Order Page
	      </button>
	    </a>
  	</div>

  	<div class="main_section">
  		<div class="form-group">
		    <label class="control-label" for="category">Category :</label>
	    	<select class="form-control" id="po_category" name="po_category" required="">
		    	<option value=""> Select Category </option>
        	</select>
		  </div>
  	</div>
@endsection

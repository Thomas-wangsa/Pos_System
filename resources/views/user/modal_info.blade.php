<style type="text/css">
	tbody #info_tbody tr th {background-color: red} 
</style>

<!-- Modal -->
  <div class="modal fade" id="modal_info" role="dialog">
    <div class="modal-dialog">
    
      <!-- Modal content-->
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
          <h4 class="modal-title text-center" >
          	User
          </h4>
        </div>
        <div class="modal-body">
  			<div class="panel panel-primary">
		      <div class="panel-heading text-center">
		      	User Information
		      </div>
		      	<div class="panel-body">
			      	<div class="table-responsive">          
					 	<table class="table 
					 	table-condensed table-hover table-bordered table-striped">
						    <tbody>
						      <tr class="info">
						        <th> name </th>
						        <td id="modal_info_name">  </td>
						      </tr>
						      <tr>
						        <th>  email </th>
						        <td id="modal_info_email">   </td>
						      </tr>
						      <tr>
						        <th> phone </th>
						        <td id="modal_info_phone">  </td>
						      </tr>
						      <tr>
						        <th> role </th>
						        <td id="modal_info_role">  </td>
						      </tr>		
						      <tr>
						        <th> created by </th>
						        <td id="modal_info_created_by">  </td>
						      </tr>
						      <tr>
						        <th> updated by </th>
						        <td id="modal_info_updated_by">  </td>
						      </tr>

						    </tbody>
					  	</table>


					</div>
		      	</div> <!--panel body-->
		    </div> <!--panel-->



  		</div> <!--modal body-->
        <div class="modal-footer">
          <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
        </div>
      
     </div> <!--modal content-->


    </div>
  </div>



<script type="text/javascript">
	$.ajaxSetup({
    	headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    	}
  	});

	function info(uuid) {
		$('#modal_info_name').html("-");
		$('#modal_info_email').html("-");
		$('#modal_info_phone').html("-");
		$('#modal_info_role').html("-");
		$('#modal_info_created_by').html("-");
		$('#modal_info_updated_by').html("-");

		var payload = {"uuid":uuid};


		$.ajax({
			type : "POST",
			url: " {{ route('user.get_user_by_uuid') }}",
			contentType: "application/json",
			data : JSON.stringify(payload),
			success: function(result) {
				response = JSON.parse(result);
				if(response.error != true) {
					$('#modal_info_name').html(response.data.name);
					$('#modal_info_email').html(response.data.email);
					$('#modal_info_phone').html(response.data.phone);
					$('#modal_info_role').html(response.data.role_name);

					$('#modal_info_created_by').html(response.data.created_by_name+" : "+response.data.created_at);
					$('#modal_info_updated_by').html(response.data.updated_by_name+" : "+response.data.updated_at);


					$('#modal_info').modal('show');
				} else {
					alert(response.messages);
				}

			}

		});
		
	}
</script>
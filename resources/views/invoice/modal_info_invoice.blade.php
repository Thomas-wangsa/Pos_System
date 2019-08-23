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
          	Invoice
          </h4>
        </div>
        <div class="modal-body">
  			<div class="panel panel-primary">
		      <div class="panel-heading text-center">
		      	Basic Information
		      </div>
		      	<div class="panel-body">
			      	<div class="table-responsive">          
					 	<table class="table 
					 	table-condensed table-hover table-bordered table-striped">
						    <tbody id="info_tbody">
						      <tr class="info">
						        <th> po number </th>
						        <td id="modal_info_request_type"> test </td>
						      </tr>
						      <tr>
						        <th> sales </th>
						        <td id="modal_info_request_type">  test </td>
						      </tr>
						      <tr>
						        <th> invoice number </th>
						        <td id="modal_info_request_type"> test </td>
						      </tr>
						      

						      <tr>
						        <th> date </th>
						        <td id="modal_info_register_type"> test </td>
						      </tr>		
						     
			
						      <tr class="info">
						        <th> status </th>
						        <td id="modal_info_status_akses">  </td>
						      </tr>
						      <tr>
						        <th> created by </th>
						        <td id="modal_info_created_by">  </td>
						      </tr>
						      <tr>
						        <th> updated by </th>
						        <td id="modal_info_updated_by">  </td>
						      </tr>
						      <tr>
						        <th style="min-width: 200px"> note </th>
						        <td id="modal_info_additional_note">  </td>
						      </tr>

						    </tbody>
					  	</table>
					</div>
		      	</div> <!--panel body-->
		    </div> <!--panel-->

		    <table class="table 
			table-condensed table-hover table-bordered table-striped">
				<thead>
					<tr>
						<td> no </td>
						<td> qty </td>
						<td> desc </td>
						<td> price </td>
					</tr>
				</thead>
			    <tbody id="info_tbody">
			      <tr> 
			      	<td> 1 </td>
			      	<td> 10 </td>
			      	<td> sofa kelas 1 </td>
			      	<td> 5.000.000 </td>
			      </tr>
			      <tr> 
			      	<td> 2 </td>
			      	<td> 50 </td>
			      	<td> sofa kelas 2 </td>
			      	<td> 50.000 </td>
			      </tr>
			    </tbody>
			</table>


  		</div> <!--modal body-->
        <div class="modal-footer">
          <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
        </div>
      
     </div> <!--modal content-->


    </div>
  </div>



<script type="text/javascript">
	function info(uuid) {
		$('#modal_info').modal('show');
	}
</script>
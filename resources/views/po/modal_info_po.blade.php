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
          	Purchase Order
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
						    <tbody>
						      <tr class="info">
						        <th> po number </th>
						        <td id="modal_info_number">  </td>
						      </tr>
						      <tr>
						        <th> customer name </th>
						        <td id="modal_info_customer_name">   </td>
						      </tr>
						      <tr>
						        <th> sales name </th>
						        <td id="modal_info_sales_name">  </td>
						      </tr>
						      

						      <tr>
						        <th> date </th>
						        <td id="modal_info_date"> test </td>
						      </tr>		
						     
			
						      <tr class="info">
						        <th> status </th>
						        <td id="modal_info_status_name">  </td>
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
						        <td id="modal_info_note">  </td>
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
			    <tbody id="info_sub_tbody">
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
			      	<td> 500.000 </td>
			      </tr>
			    </tbody>
			</table>

		    <div class="panel panel-primary" id="head_modal_document">
		      <div class="panel-heading text-center" id="body_modal_document">
		      	Delivery Order List
		      </div>
		      	<div class="panel-body">

		      	</div> <!--panel body-->
		      	<div class="panel-footer"></div>
		    </div> <!--panel-->


		    <div class="panel panel-primary" id="head_modal_info_po">
		      <div class="panel-heading text-center">
		      	Invoice List
		      </div>
		      	<div class="panel-body">

		      	</div> <!--panel body-->
		      	<div class="panel-footer"></div>
		    </div> <!--panel-->

  		</div> <!--modal body-->
        <div class="modal-footer">
          <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
        </div>
      
     </div> <!--modal content-->


    </div>
  </div>



<script type="text/javascript">
	function info(uuid) {
		$('#modal_info_number').html("-");
		$('#modal_info_customer_name').html("-");
		$('#modal_info_sales_name').html("-");
		$('#modal_info_date').html("-");
		$('#modal_info_status_name').html("-");
		$('#modal_info_created_by').html("-");
		$('#modal_info_updated_by').html("-");
		$('#modal_info_note').html("-");

		$('#info_sub_tbody').empty();
		var payload = {"uuid":uuid};

		$.ajax({
			type : "POST",
			url: " {{ route('po.get_po_by_uuid') }}",
			contentType: "application/json",
			data : JSON.stringify(payload),
			success: function(result) {
				response = JSON.parse(result);
				if(response.error != true) {
					$('#modal_info_number').html(response.data.po.number);
					$('#modal_info_customer_name').html(response.data.po.customer_name);
					$('#modal_info_sales_name').html(response.data.po.sales_name);
					$('#modal_info_date').html(response.data.po.date);
					$('#modal_info_status_name').html(response.data.po.status_name);
					$('#modal_info_created_by').html(response.data.po.created_by_name+" : "+response.data.po.created_at);
					$('#modal_info_updated_by').html(response.data.po.updated_by_name+" : "+response.data.po.updated_at);
					$('#modal_info_note').html(response.data.po.note);

					if(response.data.sub_po.length > 0) {
						$.each(response.data.sub_po, function (key,val) {

							var append_rows = "<tr> " +
												"<td> " +
												(key+1) +
												"</td> " +
												"<td> " +
												val.quantity +
												"</td> " +
												"<td> " +
												val.name +
												"</td> " +
												"<td> " +
												"Rp. " + val.price.toLocaleString() +
												"</td> " +
											  "<tr>";
							$('#info_sub_tbody').append(append_rows);
						});
					}

					// $.each(response.data, function (key,val) {


					// });
					// $('#modal_info_po_number').html(response.data.po.number);
					// alert(response.data.po.number);
					$('#modal_info').modal('show');
				} else {
					alert(response.messages);
				}	
			}
		})


		
	}
</script>
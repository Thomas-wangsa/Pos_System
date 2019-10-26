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
						    <tbody>
						      <tr class="info">
						        <th> invoice number </th>
						        <td id="modal_info_number">  </td>
						      </tr>

						      <tr>
						        <th> sales name </th>
						        <td id="modal_info_sales_name">  </td>
						      </tr>

						      <tr>
						        <th> customer name </th>
						        <td id="modal_info_customer_name">  </td>
						      </tr>


						      <tr>
						        <th>  po number </th>
						        <td id="modal_info_po_number">   </td>
						      </tr>


						      <tr>
						        <th> delivery order number </th>
						        <td id="modal_info_delivery_order_number">  </td>
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

					  	<div class="text-center" style="margin-bottom: 10px"> 
					  		Invoice Detail Information : 
					  	</div>

					    <table class="table 
						table-condensed table-hover table-bordered table-striped">
							<thead>
								<tr>
									<td> no </td>
									<td> qty </td>
									<td> desc </td>
									<td> price </td>
									<td> total </td>
									<td> note </td>
								</tr>
							</thead>
						    <tbody id="info_sub_tbody">
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
		$('#modal_info_number').html("-");
		$('#modal_info_sales_name').html("-");
		$('#modal_info_customer_name').html("-");
		$('#modal_info_po_number').html("-");
		$('#modal_info_delivery_order_number').html("-");



		$('#modal_info_status_name').html("-");
		$('#modal_info_created_by').html("-");
		$('#modal_info_updated_by').html("-");
		$('#modal_info_note').html("-");

		$('#info_sub_tbody').empty();
		var payload = {"uuid":uuid};


		$.ajax({
			type : "POST",
			url: " {{ route('invoice.get_invoice_by_uuid') }}",
			contentType: "application/json",
			data : JSON.stringify(payload),
			success: function(result) {
				response = JSON.parse(result);
				if(response.error != true) {
					$('#modal_info_number').html(response.data.invoice.number);
					$('#modal_info_sales_name').html(response.data.invoice.sales_name);
					$('#modal_info_customer_name').html(response.data.invoice.customer_name);
					$('#modal_info_po_number').html(response.data.invoice.po_number);
					$('#modal_info_delivery_order_number').html(response.data.invoice.delivery_order_number);

					$('#modal_info_status_name').html(response.data.invoice.status_name);
					$('#modal_info_created_by').html(response.data.invoice.created_by_name+" : "+response.data.invoice.created_at);
					$('#modal_info_updated_by').html(response.data.invoice.updated_by_name+" : "+response.data.invoice.updated_at);
					$('#modal_info_note').html(response.data.invoice.note);

					if(response.data.sub_invoice.length > 0) {
						$.each(response.data.sub_invoice, function (key,val) {

							total = val.quantity * val.price;
							
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
												"<td> " +
												"Rp. " + total.toLocaleString() +
												"</td> " +
												"<td> " +
												val.note +
												"</td> " +
											  "<tr>";
							$('#info_sub_tbody').append(append_rows);
						});
					}

					$('#modal_info').modal('show');
				} else {
					alert(response.messages);
				}

			}

		});
		
	}
</script>
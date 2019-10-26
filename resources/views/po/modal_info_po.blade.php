<style type="text/css">
	tbody #info_tbody tr th {background-color: red} 
</style>

<!-- Modal -->
  <div class="modal fade" id="modal_info" role="dialog">
    <div class="modal-dialog">
    
      <!-- Modal content-->
      <div class="modal-content modal-lg">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
          <h4 class="modal-title text-center" >
          	Purchase Order
          </h4>
        </div>
        <div class="modal-body">
  			<div class="panel panel-primary">
		      <div class="panel-heading text-center">
		      	Purchase Order Information
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
						        <th> grand total </th>
						        <td id="modal_info_grand_total">  </td>
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
					  		PO Detail Information : 
					  	</div>

					    <table class="table 
						table-condensed table-hover table-bordered table-striped">
							<thead>
								<tr>
									<td> no </td>
									<td> qty </td>
									<td> name </td>
									<td> price </td>
									<td> total </td>
								</tr>
							</thead>
						    <tbody id="info_sub_tbody">
						    </tbody>
						</table>

					</div>
		      	</div> <!--panel body-->
		    </div> <!--panel-->


		    <div class="panel panel-success" id="head_modal_document">
		      <div class="panel-heading text-center" id="body_modal_document">
		      	Delivery Order List
		      </div>
		      	<div class="panel-body">
		      		<table class="table 
					table-condensed table-hover table-bordered table-striped">
						<thead>
							<tr>
								<td> no </td>
								<td> date </td>
								<td> number </td>
								<td> quantity </td>
								<td> name </td>
								<td> status </td>
							</tr>
						</thead>
					    <tbody id="info_delivery_order_tbody">
					    </tbody>
					</table>
		      	</div> <!--panel body-->
		      	<div class="panel-footer"></div>
		    </div> <!--panel-->


		    <div class="panel panel-danger" id="head_modal_info_po">
		      <div class="panel-heading text-center">
		      	Invoice List
		      </div>
		      	<div class="panel-body">
		      		<table class="table 
					table-condensed table-hover table-bordered table-striped">
						<thead>
							<tr>
								<td> no </td>
								<td> date </td>
								<td> number </td>
								<td> quantity </td>
								<td> name </td>
								<td> price </td>
								<td> total </td>
								<td> status </td>
							</tr>
						</thead>
					    <tbody id="info_invoice_tbody">
					    </tbody>
					</table>
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
		$('#modal_info_status_name').html("-");
		$('#modal_info_created_by').html("-");
		$('#modal_info_updated_by').html("-");
		$('#modal_info_note').html("-");
		$('#modal_info_grand_total').html("-");

		$('#info_sub_tbody').empty();
		$('#info_delivery_order_tbody').empty();
		$('#info_invoice_tbody').empty();
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
					$('#modal_info_status_name').html(response.data.po.status_name);
					$('#modal_info_created_by').html(response.data.po.created_by_name+" : "+response.data.po.created_at);
					$('#modal_info_updated_by').html(response.data.po.updated_by_name+" : "+response.data.po.updated_at);
					$('#modal_info_note').html(response.data.po.note);
					$('#modal_info_grand_total').html("Rp. " + response.data.po.grand_total.toLocaleString());

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
												"<td> " +
												"Rp. " + val.total.toLocaleString() +
												"</td> " +
											  "<tr>";
							$('#info_sub_tbody').append(append_rows);
						});
					}


					if(response.data.delivery_order.length > 0) {
						$.each(response.data.delivery_order, function (key,val) {


							var append_rows = "<tr> " +
												'<td> ' +
												(key+1) +
												"</td> " +
												'<td> ' +
												val.updated_at +
												"</td> " +
												'<td> ' +
												val.number +
												"</td> ";

							append_rows +=  '<td>' +
											val.sub_delivery_order_quantity +
											'</td>' +
											'<td>' +
											val.sub_delivery_order_name +
											'</td>';
							

							append_rows +=	'<td> ' +
											val.status_name +
											"</td> " +
											 "<tr>";
							$('#info_delivery_order_tbody').append(append_rows);
						});
					} else {
						$('#info_delivery_order_tbody').append("<tr> <td colspan='6'> no delivery order found! </td></tr>");
					}



					if(response.data.invoice.length > 0) {
						$.each(response.data.invoice, function (key,val) {

							total = val.sub_invoice_quantity * val.sub_invoice_price;

							var append_rows = "<tr> " +
												'<td> ' +
												(key+1) +
												"</td> " +
												'<td> ' +
												val.updated_at +
												"</td> " +
												'<td> ' +
												val.number +
												"</td> ";

							append_rows +=  '<td>' +
											val.sub_invoice_quantity +
											'</td>' +
											'<td>' +
											val.sub_invoice_name +
											'</td>'+
											'<td>' +
											val.sub_invoice_price.toLocaleString() +
											'</td>'+
											'<td>' +
											total.toLocaleString() +
											'</td>';
							

							append_rows +=	'<td> ' +
											val.status_name +
											"</td> " +
											 "<tr>";
							$('#info_invoice_tbody').append(append_rows);
						});
					} else {
						$('#info_invoice_tbody').append("<tr> <td colspan='10'> no invoice found! </td></tr>");
					}


					// if(response.data.invoice.length > 0) {
					// 	$.each(response.data.delivery_order, function (key,val) {

					// 		var append_rows = "<tr> " +
					// 							"<td> " +
					// 							(key+1) +
					// 							"</td> " +
					// 							"<td> " +
					// 							val.number +
					// 							"</td> " +
					// 							"<td> " +
					// 							val.date +
					// 							"</td> " +
					// 							"<td> " +
					// 							val.status_name +
					// 							"</td> " +
					// 						  "<tr>";
					// 		$('#info_invoice_tbody').append(append_rows);
					// 	});
					// } else {
					// 	$('#info_invoice_tbody').append("<tr> <td colspan='6'> no invoice found! </td></tr>");
					// }

					$('#modal_info').modal('show');
				} else {
					alert(response.messages);
				}	
			}
		})


		
	}
</script>
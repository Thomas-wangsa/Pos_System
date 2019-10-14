<!-- modal -->
<div class="modal fade" id="modal_select_po" role="dialog">
  <div class="modal-dialog">
    <!-- modal content-->
    <div class="modal-content">

      
      <!-- modal header-->
      <div class="modal-header" style="border-bottom:0px">
          <button type="button" 
          class="close" data-dismiss="modal">
            &times;
          </button>
          <h4 class="modal-title text-center">
            Select PO First :
          </h4>
      </div>
      <!-- modal header-->


      <!-- modal body-->
      <div class="modal-body">
        <form method="GET" action="{{route('do.create')}}">
          
          <div class="form-group">
            <label for="staff_nama"> 
              Category :
            </label>
            <select class="form-control" id="select_category">
              <option value=""> Select Category </option>
              @foreach($data['category'] as $key=>$val)
              <option value="{{$val->id}}"> {{$val->name}} </option>
              @endforeach
            </select>
          </div>

          <div class="form-group">
            <label for="staff_nama"> 
              Customers :
            </label>
            <select class="form-control" id="customer_uuid" name="customer_uuid">
              <option value=""> Select Customer </option>
            </select>
          </div>


          <div class="form-group">
            <label for="staff_nama"> 
              PO :
            </label>
            <select class="form-control" id="po_uuid" name="po_uuid">
              <option value=""> Select PO </option>
            </select>
          </div>


          <button type="submit" class="btn btn-block btn-warning">
            Create New Delivery_Order 
          </button>
        </form>
      </div>
      <!-- modal body-->

      <!-- modal footer-->
      <div class="modal-footer">
        <button type="button" 
        class="btn btn-danger" data-dismiss="modal">
          Close
      </button>
      </div>
      <!-- modal footer-->


    </div>
    <!-- modal content-->
  </div>
</div>
<!-- modal -->

<script type="text/javascript">


  $.ajaxSetup({
    headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    }
  });


  $('#select_category').change(function(){
    category_id = $('#select_category').val();
    $('#customer_uuid').empty().append(
      $("<option></option>")
      .attr("value","")
      .text("Select Customer")
    );
    var data = {
      "category_id":category_id
    };

    $.ajax({
      type : "POST",
      url: " {{ route('customer.get_customer_by_category_id') }}",
      contentType: "application/json",
      data : JSON.stringify(data),
      success: function(result) {
        response = JSON.parse(result);
        if(response.error == true) {
          alert(response.messages);
        } else { 
          
          $.each(response.data, function(key, value) { 
            $('#customer_uuid')
              .append($("<option></option>")
              .attr("value",value.uuid)
              .text(value.name)
            );
          });
        } 
      }
    });

  });





  $('#customer_uuid').change(function(){
    customer_uuid = $('#customer_uuid').val();
    $('#po_uuid').empty().append(
      $("<option></option>")
      .attr("value","")
      .text("Select PO")
    );
    var data = {
      "customer_uuid":customer_uuid
    };

    $.ajax({
      type : "POST",
      url: " {{ route('po.get_po_by_customer_uuid') }}",
      contentType: "application/json",
      data : JSON.stringify(data),
      success: function(result) {
        response = JSON.parse(result);
        if(response.error == true) {
          alert(response.messages);
        } else { 
          
          $.each(response.data, function(key, value) { 
            $('#po_uuid')
              .append($("<option></option>")
              .attr("value",value.uuid)
              .text(value.number)
            );
          });
        } 
      }
    });

  });


</script>



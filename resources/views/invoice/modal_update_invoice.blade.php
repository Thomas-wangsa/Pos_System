<!-- modal -->
<div class="modal fade" id="modal_update_invoice_status" role="dialog">
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
            Update Invoice Status:
          </h4>
      </div>
      <!-- modal header-->


      <!-- modal body-->
      <div class="modal-body">
        <form method="POST" action="{{route('invoice.set_success_status_invoice')}}">
          {{ csrf_field() }}
          <input type="hidden" id="invoice_uuid" name="invoice_uuid" value="">
          <div class="form-group">
            <label for="staff_nama"> 
              Invoice Status :
            </label>
            <select class="form-control" id="status" name="status" disabled="">
              <option> Success </option>
            </select>
          </div>

          <div class="form-group">
            <label for="staff_nama"> 
              Payment Detail :
            </label>
            <input class="form-control" type="text" id="payment_detail" name="payment_detail"
            placeholder="eg : Giro no BRI-XXX, BCA-XXX">
          </div>

          <button type="submit" class="btn btn-block btn-danger">
            UPDATE INVOICE STATUS
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
  function update_invoice_status(uuid) {
    $('#invoice_uuid').val(uuid);
    $('#modal_update_invoice_status').modal('show');
  }
</script>




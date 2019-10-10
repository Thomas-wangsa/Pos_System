<!-- modal -->
<div class="modal fade" id="modal_select_po_status" role="dialog">
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
            Update PO Status:
          </h4>
      </div>
      <!-- modal header-->


      <!-- modal body-->
      <div class="modal-body">
        <form method="POST" action="{{route('po.edit_status_po')}}">
          {{ csrf_field() }}
          <input type="hidden" id="select_po_status_po_uuid" name="po_uuid" value="">
          <div class="form-group">
            <label for="staff_nama"> 
              PO Status :
            </label>
            <select class="form-control" id="status" name="status">
              @foreach($data['po_status'] as $key=>$val)
              <option value="{{$val->id}}"> 
                {{$val->name}} 
              </option>
              @endforeach
            </select>
          </div>

          <button type="submit" class="btn btn-block btn-primary">
            UPDATE PO STATUS
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
  function select_sub_po_status(uuid) {
    $('#select_po_status_po_uuid').val(uuid);
    $('#modal_select_po_status').modal('show');
  }
</script>




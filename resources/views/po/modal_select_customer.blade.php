<!-- modal -->
<div class="modal fade" id="modal_select_customer" role="dialog">
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
            Select Customer First :
          </h4>
      </div>
      <!-- modal header-->


      <!-- modal body-->
      <div class="modal-body">
        <form method="GET" action="{{route('po.create')}}">
          
          <div class="form-group">
            <label for="staff_nama"> 
              Customers :
            </label>
            <select class="form-control" id="customer_uuid" name="customer_uuid">
              <option value=""> Select Customer </option>
              @foreach($data['customer'] as $key=>$val)
              <option value="{{$val->uuid}}"> {{$val->name}} </option>
              @endforeach
            </select>
          </div>

          <button type="submit" class="btn btn-block btn-warning">
            CREATE NEW PO 
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




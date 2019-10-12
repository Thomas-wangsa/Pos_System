@extends('layouts.main')

@section('content')
  @foreach (['danger', 'warning', 'success', 'info'] as $msg)
    @if(Session::has('alert-' . $msg))
      <p class="alert alert-{{ $msg }}">{{ Session::get('alert-' . $msg) }} 
        <a href="#" class="close" data-dismiss="alert" aria-label="close">
          &times;
        </a>
     </p>
    @endif
  @endforeach
  <div style="margin-top: 15px">
    <div id="helper_header">

      <div class="pull-left">  
        <button type="button" class="btn btn-md btn-primary" data-toggle="modal" data-target="#modal_new_config">
          add new configuration
        </button>
      </div>
      <div class="clearfix" style="margin-bottom: 10px"> </div>


      <div class="pull-left">
        <form class="form-inline" action="{{route('config.index')}}">

          <input type="hidden" name="search" value="on"> </input>
          
          <div class="form-group">
            <div class="input-group">
              <span class="input-group-addon">
                <i class="glyphicon glyphicon-search">
                </i>
              </span>
              <input type="text" class="form-control" 
              name="search_nama" placeholder="Find Name..."
              value="{{Request::get('search_nama')}}">
            </div>
          </div>


          <div class="form-group">
            <select class="form-control" name="search_filter" required="">
              <option value=""> Select Config </option>
              @foreach($data['config'] as $key=>$val)
                <option value="{{$val}}"
                @if($val == Request::get('search_filter')) 
                selected
                @endif
                >
                  {{$key}}
                </option>
              @endforeach
            </select>
          </div>


          <button type="submit" class="btn btn-info"> 
              Filter
            </button>
            <button type="reset" 
            class="btn"
            onclick="reset_filter()"> 
              Clear Filter 
          </button>


        </form>
      </div>
      <div class="clearfix" style="margin-bottom: 10px"> </div>
    </div> <!-- helper header-->


    <div id="helper_body">
      <div class="scrollme">
        <table class="table table-bordered table-responsive">
            <thead>
               <tr>
                  <th> No </th>
                  <th> Type </th>
                  <th> Name </th>
                  <th> Detail </th>
                  <th> Created By </th>
                  <th> Updated By </th>
                  <th> Action </th>
                </tr>
          </thead>
          <tbody>
            @if($data['rows'] == null ) 
              <td colspan="10" class="text-center"> Please select the type config </td>
            @elseif(count($data['rows']) < 1)
              <td colspan="10" class="text-center"> Data not found! </td>
            @else 
              <?php $no=1;?>

                @switch(Request::get('search_filter'))
                    @case(1)
                        <?php $val_name="name";$val_detail="detail";$category_value = "category";?>
                        @break
                    @case(2)
                      <?php $val_name="name";$val_detail="detail";$category_value = "driver";?>
                        @break
                    @default
                      @break
                @endswitch

                <?php $type= Request::get('search_filter');?>

                @foreach($data['rows'] as $key=>$val)
                <tr>
                  <td> {{$no}} </td>
                  <td> 
                    {{$category_value}}
                  </td>
                  <td> 
                    {{$val->$val_name}}
                  </td>
                  <td> 
                    {{$val->$val_detail}}
                  </td>
                  <td> 
                    {{$val->created_by_user}} 
                    <br/>
                    {{$val->created_at}}
                  </td>
                  <td> 
                    {{$val->updated_by_user}}
                    <br/>
                    {{$val->updated_at}}
                  </td>
                  <td> 
                    <div class="btn-group-vertical"> 
                    <button 
                    class="btn btn-warning"
                    onclick="edit_config('{{$type}}','{{$val->uuid}}')"
                    >
                      Edit {{ucwords($category_value)}} Config
                    </button>

                    <button 
                    class="btn btn-danger"
                    onclick="delete_config('{{$type}}','{{$val->uuid}}')"
                    >
                      Delete {{ucwords($category_value)}} Config
                    </button>
                    </div>
                  </td>
                </tr>
                <?php $no++;?>
                @endforeach
            @endif
          </tbody>
        </table> 
      </div>
    </div>
  </div>
  @include('config.modal_new_config')

  <script type="text/javascript">
    
    function edit_config(type,uuid) {
      if(type == 1) {
        window.location = "{{route('config.edit_config')}}"+"?uuid="+uuid;
      } else if(type == 2) {
        window.location = "{{route('config.edit_driver')}}"+"?uuid="+uuid;
      } else {
        alert("ERROR, undefined type");
      }
    }


    function delete_config(type,uuid) {
      if (confirm('Apakah anda yakin ingin menghapus data ini ?')) {
        window.location = "{{route('config.delete_config')}}"+"?type="+type+"&uuid="+uuid;
      }
    }



    function reset_filter() {
      window.location = "{{route('config.index')}}";
    }

  </script>
@endsection

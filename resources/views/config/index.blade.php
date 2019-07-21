@extends('layouts.main')

@section('content')
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
                  <th> Category </th>
                  <th> Name </th>
                  <th> Detail </th>
                  <th> Created By </th>
                  <th> Updated By </th>
                  <th> Action </th>
                </tr>
          </thead>
          <tbody>
            @if($data['rows'] == null ) 
              <td colspan="10" class="text-center"> Please select the category </td>
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
                    <button 
                    class="btn btn-warning"
                    onclick="edit_config('{{$val->id}}','{{$val->$val_name}}','{{$val->$val_detail}}')"
                    >
                      Edit {{ucwords($category_value)}} Config
                    </button>

                    <button 
                    class="btn btn-danger"
                    onclick="edit_config('{{$val->id}}','{{$val->$val_name}}','{{$val->$val_detail}}')"
                    >
                      Delete {{ucwords($category_value)}} Config
                    </button>
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
@endsection

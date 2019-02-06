@extends('layouts/default')



{{-- Page title --}}
@section('title')
     {{ trans('admin/hardware/general.request') }}
@parent
@stop

{{-- Page content --}}
@section('content')

<style>

.input-group {
    padding-left: 0px !important;
}
</style>
<div class="row">
  <!-- left column -->
  <div class="col-md-7">
    <div class="box box-default">
            
           
    <!-- Grifu route the answer  -->
    <form  class="form-horizontal" action="{{ route('account/requestout-asset', ['assetId' => $asset->id])}}" method="POST" accept-charset="utf-8" autocomplete="off">
            {{ csrf_field() }}    
  

        <div class="box-header with-border">
            <h3 class="box-title"> {{ trans('admin/hardware/form.tag') }} {{ $asset->asset_tag }}</h3>
        </div>
        <div class="box-body">
            {{csrf_field()}}
            @if ($asset->model->name)
            <!-- Model name -->
            <div class="form-group {{ $errors->has('name') ? 'error' : '' }}">
                {{ Form::label('name', trans('admin/hardware/form.model'), array('class' => 'col-md-3 control-label')) }}
              <div class="col-md-8">
                <p class="form-control-static">{{ $asset->model->name }}</p>
              </div>
            </div>
            @endif

            <!-- Asset Name -->
            <div class="form-group {{ $errors->has('name') ? 'error' : '' }}">
              {{ Form::label('name', trans('admin/hardware/form.name'), array('class' => 'col-md-3 control-label')) }}
              <div class="col-md-8">
                <input class="form-control" type="text" name="name" id="name" value="{{ Input::old('name', $asset->name) }}" tabindex="1">
                {!! $errors->first('name', '<span class="alert-msg"><i class="fa fa-times"></i> :message</span>') !!}
              </div>
            </div>
                @include ('partials.forms.checkout-selector', ['user_select' => 'true','asset_select' => 'false', 'location_select' => 'false'])
<!-- GRIFU  Sending the user id to the user-select view -->

                @include ('partials.forms.edit.user-select', ['translated_name' => trans('general.user'), 'user_id' => $user->id,'fieldname' => 'assigned_user', 'required'=>'true'])




                <!-- ('partials.forms.edit.user-select', ['translated_name' => trans('general.responsible'), 'group_id' => "1",'fieldname' => 'responsible', 'required'=>'true']) -->
                <!-- GRIFU: Future work: filter users within a group -->
                @include ('partials.forms.edit.user-select', ['translated_name' => trans('general.responsible'), 'group_id' => "1",'fieldname' => 'responsible', 'required'=>'true'])

                <!-- We have to pass unselect here so that we don't default to the asset that's being checked out. We want that asset to be pre-selected everywhere else. -->
                @include ('partials.forms.edit.asset-select', ['translated_name' => trans('general.asset'), 'fieldname' => 'assigned_asset', 'unselect' => 'true', 'style' => 'display:none;', 'required'=>'true'])

                @include ('partials.forms.edit.location-select', ['translated_name' => trans('general.location'), 'fieldname' => 'assigned_location', 'style' => 'display:none;', 'required'=>'true'])


  


              <!-- Checkout/Checkin Date  -->
              <div class="form-group {{ $errors->has('checkout_at') ? 'error' : '' }}">
                {{ Form::label('name', trans('admin/hardware/form.checkout_date'), array('class' => 'col-md-3 control-label')) }}
                <div class="col-md-8">
                    <div class='col-sm-6'>
                        <div class="form-group" data-provide="datetimepicker" data-date-format="yyyy-mm-dd hh:ii:ss">
                            <div class='input-group date' id='checkout_at'>
                                <input type='text' class="form-control" placeholder="{{ trans('general.select_date') }}" name="checkout_at" value="{{ Input::old('checkout_at') }}">
                                <span class="input-group-addon"><i class="fa fa-calendar"></i></span>
                                </span>
                            </div>
                        </div>
                    </div>
                    {!! $errors->first('checkout_at', '<span class="alert-msg"><i class="fa fa-times"></i> :message</span>') !!}
                </div>
            </div>

            <!-- Expected Checkin Date -->
            <div class="form-group {{ $errors->has('expected_checkin') ? 'error' : '' }}">
                {{ Form::label('name', trans('admin/hardware/form.expected_checkin'), array('class' => 'col-md-3 control-label')) }}
                <div class="col-md-8">
                    <div class='col-sm-6'>
                        <div class="form-group" data-provide="datetimepicker" data-date-format="yyyy-mm-dd hh:ii:ss">
                            <div class='input-group date' id='expected_checkin'>
                                <input type='text' class="form-control" placeholder="{{ trans('general.select_date') }}" name="expected_checkin" value="{{ Input::old('expected_checkin') }}">
                                <span class="input-group-addon"><i class="fa fa-calendar"></i></span>
                                </span>
                            </div>
                        </div>
                    </div>
                    {!! $errors->first('expected_checkin', '<span class="alert-msg"><i class="fa fa-times"></i> :message</span>') !!}
                </div>
            </div>

            <!-- Note -->
            <div class="form-group {{ $errors->has('note') ? 'error' : '' }}">
              {{ Form::label('note', trans('admin/hardware/form.notes'), array('class' => 'col-md-3 control-label')) }}
              <div class="col-md-8">
                <textarea class="col-md-6 form-control" id="note" name="note">{{ Input::old('note', $asset->note) }}</textarea>
                {!! $errors->first('note', '<span class="alert-msg"><i class="fa fa-times"></i> :message</span>') !!}
              </div>
            </div>

                @if ($asset->requireAcceptance() || $asset->getEula() || ($snipeSettings->slack_endpoint!=''))
                    <div class="form-group notification-callout">
                        <div class="col-md-8 col-md-offset-3">
                            <div class="callout callout-info">

                                    @if ($asset->requireAcceptance())
                                        <i class="fa fa-envelope"></i>
                                    {{ trans('admin/categories/general.required_acceptance') }}
                                        <br>
                                    @endif

                                    @if ($asset->getEula())
                                        <i class="fa fa-envelope"></i>
                                       {{ trans('admin/categories/general.required_eula') }}
                                        <br>
                                    @endif

                                    @if ($snipeSettings->slack_endpoint!='')
                                        <i class="fa fa-slack"></i>
                                       A slack message will be sent
                                    @endif
                            </div>
                        </div>
                    </div>
                 @endif



                    
        </div> <!--/.box-body-->




        <div class="box-footer">
          <a class="btn btn-link" href="{{ URL::previous() }}"> {{ trans('button.cancel') }}</a>

         
          <button type="submit" class="btn btn-success pull-right"><i class="fa fa-check icon-white"></i> {{ trans('button.request') }}</button>
        </div>
      </form>
    </div>
  </div> <!--/.col-md-7-->

  <!-- right column -->
  <div class="col-md-5" id="current_assets_box" style="display:none;">
    <div class="box box-primary">
      <div class="box-header with-border">
        <h3 class="box-title">{{ trans('admin/users/general.current_assets') }}</h3>
      </div>
      <div class="box-body">
        <div id="current_assets_content">
        </div>
      </div>
    </div>
  </div>
</div>
@stop

@section('moar_scripts')

<!-- GRIFU -->
<script>

    var transformed_oldvals={};
    function fetchCustomFields() {
        
        var oldvals = $('#custom_fields_content').find('input,select').serializeArray();
        for(var i in oldvals) {
            transformed_oldvals[oldvals[i].name]=oldvals[i].value;
            printf(transformed_oldvals[oldvals[i].name]);
        }

         var modelid = $('#model_select_id').val();
        if (modelid == '') {
            $('#custom_fields_content').html("");
        } else {

            $.ajax({
                type: 'GET',
                url: "{{url('/') }}/models/" + modelid + "/custom_fields",
                headers: {
                    "X-Requested-With": 'XMLHttpRequest',
                    "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr('content')
                },
                _token: "{{ csrf_token() }}",
                dataType: 'html',
                success: function (data) {
                    $('#custom_fields_content').html(data);
                    $('#custom_fields_content select').select2(); //enable select2 on any custom fields that are select-boxes
                    //now re-populate the custom fields based on the previously saved values
                    $('#custom_fields_content').find('input,select').each(function (index,elem) {
                        if(transformed_oldvals[elem.name]) {
                            $(elem).val(transformed_oldvals[elem.name]).trigger('change'); //the trigger is for select2-based objects, if we have any
                        }
                        
                    });
                }
            });
        }
    }
    $(function () {
        //grab custom fields for this model whenever model changes.
        $('#model_select_id').on("change", fetchCustomFields);


    }

    </script>


    @include('partials/assets-assigned')


    <script>


        $.fn.datetimepicker.defaults.icons = {
            time: 'fa fa-clock-o',
            date: 'fa fa-calendar',
            up: 'fa fa-chevron-up',
            down: 'fa fa-chevron-down',
            previous: 'fa fa-chevron-left',
            next: 'fa fa-chevron-right',
            today: 'fa fa-dot-circle-o',
            clear: 'fa fa-trash',
            close: 'fa fa-times'
        };

var $start = $('#checkout_at');

        $('#checkout_at').datetimepicker({
          locale: 'pt', // Extract this from the language selection
          minDate: new Date(),  // today date
         //   daysOfWeekDisabled: [0, 6],  // this should be set in the configuration 
            format: 'YYYY-MM-DD HH:mm:ss'
        });

        $('#expected_checkin').datetimepicker({

          locale: 'pt', // Extract this from the language selection
             minDate: $start.data("DateTimePicker").date(),
          //  minDate: $('#checkout_at').val(),
         //   daysOfWeekDisabled: [0, 6],  // this should be set in the configuration 
            format: 'YYYY-MM-DD HH:mm:ss'
            

        });


           </script>




@stop

@extends('layouts/default')

{{-- Page title --}}
@section('title')
     {{ trans('admin/hardware/general.checkout') }}
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
      <form class="form-horizontal" method="post" action="" autocomplete="off">
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
                @include ('partials.forms.checkout-selector', ['user_select' => 'true','asset_select' => 'true', 'location_select' => 'true'])

                @include ('partials.forms.edit.user-select', ['translated_name' => trans('general.user'), 'userRequest_id' => $userID,'fieldname' => 'assigned_user', 'required'=>'true'])


                <!-- We have to pass unselect here so that we don't default to the asset that's being checked out. We want that asset to be pre-selected everywhere else. -->
                @include ('partials.forms.edit.asset-select', ['translated_name' => trans('general.asset'), 'fieldname' => 'assigned_asset', 'unselect' => 'true', 'style' => 'display:none;', 'required'=>'true'])

                @include ('partials.forms.edit.location-select', ['translated_name' => trans('general.location'), 'fieldname' => 'assigned_location', 'style' => 'display:none;', 'required'=>'true'])

              <!-- Checkout/Checkin Date  <p> $requests->expected_checkout </p> -->
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
                <textarea class="col-md-6 form-control" id="note" name="note">{{ Input::old('note', $notes) }}</textarea>
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
          <button id="register" type="submit" class="btn btn-success pull-right"><i class="fa fa-check icon-white"></i> {{ trans('general.checkout') }}</button>
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
    @include('partials/assets-assigned')


<script>


// This function was disable, it was not working. It was used to prevent double click
//$('#register').click(function() {
//        $(this).attr('disabled','disabled');
//});




var array = JSON.parse('{!! json_encode($requests) !!}');
var extended = JSON.parse('{!! json_encode($extended) !!}');
var notes = JSON.parse('{!! json_encode($notes) !!}');

console.log(notes);
console.log(array);
console.log(moment(array['expected_checkout']).format('YYYY-MM-DD')+'   '+array['expected_checkin']);

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


////////////////////////////////
// Proceed with
// Check if this is a checkout extension 
////////////////////////////////
if(extended == 1){


      console.log("checkout extension");
      // Function for finding the closest date
      function closeDate(datas_calendario, data_selecionada){
        let iclosest = Infinity;
        datas_calendario.forEach(function(d) {     
            const date = new Date(d);
            if (moment(date).format('YYYY-MM-DD') >= moment(data_selecionada).format('YYYY-MM-DD') && (moment(date).format('YYYY-MM-DD') < moment(iclosest).format('YYYY-MM-DD'))) {
                iclosest = d;  
            }
        });
        return new Date(iclosest);
      }

      var $selectedDate = new Date();
      // convert dates to IsoDates
      var ISOdate = [];
      array.forEach(function(item)
      {
        var currentDate = moment(item['expected_checkout']);
        var stopDate = moment(item['expected_checkin']);
        var curDate = new Date();
        if (moment(currentDate).format('YYYY-MM-DD') == moment(curDate).format('YYYY-MM-DD')) { 
            $selectedDate = moment($selectedDate).add(1, 'days').format('YYYY-MM-DD');
        }
        while (moment(currentDate).format('YYYY-MM-DD') <= moment(stopDate).format('YYYY-MM-DD')) {
          ISOdate.push(moment(currentDate).format('YYYY-MM-DD'));
          currentDate = moment(currentDate).add(1, 'days'); 
        }
      });
        
      var $datesArray = ISOdate.map( dateString => new Date(dateString) );
        
      $('#checkout_at').datetimepicker({
          defaultDate: new Date(),
          locale: 'pt', // Extract this from the language selection
          minDate: new Date(),  // today date
          disabledDates: ISOdate,
          format: 'YYYY-MM-DD HH:mm:ss',
      });


      let closeDatas = new Date("2029-09-12");

      // set the start date
      $("#expected_checkin").on("dp.change", function (e) {
          $('#expected_checkin').data("DateTimePicker").minDate($selectedDate);
      }); 

      $("#checkout_at").on("dp.change", function (e) {
          $selectedDate = e.date.toDate();
          closeDatas = closeDate($datesArray, $selectedDate);
          var m = moment(closeDatas, 'YYYY-MM-DD');
          if(m.isValid()) { 
              if(Date("y-m-d", closeDatas) != new Date()){
                  $('#expected_checkin').data("DateTimePicker").maxDate(closeDatas);
              } else{
                  $('#expected_checkin').data("DateTimePicker").maxDate(moment(closeDatas).add(1, 'days'));  
              }
          }
          $('#expected_checkin').data("DateTimePicker").minDate($selectedDate);
      });

      // Check if this is required
      $('#checkout_at').click(function() {
          $('#EventDateStart').val('');
          $('#EventDateEnd').val('');
          $('#expected_checkin').data("DateTimePicker").minDate(false);
          $('#expected_checkin').data("DateTimePicker").maxDate(false);
          return false;
      });

      $('#expected_checkin').datetimepicker({
        locale: 'pt', // Extract this from the language selection
        disabledDates: ISOdate,
          format: 'YYYY-MM-DD HH:mm:ss'
      });


} else {
        ////////////////////////////////
        // Proceed with
        // Checkout reservation 
        ////////////////////////////////
        var currentDate = moment(array['expected_checkout']);
        //  $('#checkout_at').date(array['expected_checkout']);
        $('#checkout_at').datetimepicker({
          defaultDate: array['expected_checkout'],
          locale: 'pt', // Extract this from the language selection
          minDate: array['expected_checkout'],  // date from reservation
         //   maxDate: new Date(),  // today date
         //   daysOfWeekDisabled: [0, 6],  // this should be set in the configuration 
         //   inline: true,
         //   sideBySide: true,
            format: 'YYYY-MM-DD HH:mm:ss'
        });

        $('#expected_checkin').datetimepicker({
          defaultDate: array['expected_checkin'],
          locale: 'pt', // Extract this from the language selection
          maxDate: array['expected_checkin'],  // date from reservation
            
         //   daysOfWeekDisabled: [0, 6],  // this should be set in the configuration 
            format: 'YYYY-MM-DD HH:mm:ss'
            

        });
}



</script>
@stop

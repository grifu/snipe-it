@extends('layouts/default')



{{-- Page title --}}
@section('title')
     {{ trans('admin/hardware/general.request') }}
@parent
@stop

{{-- Page content --}}
@section('content')

<style>



.bootstrap-datetimepicker-widget table td span.active {
    background-color: #337ab7;
    color: #ffffff;
    text-shadow: 0 -1px 0 rgba(0, 0, 0, 0.25);
}
#weeks {
  width: 3em;
}
.bootstrap-datetimepicker-widget table td.disabled, .bootstrap-datetimepicker-widget table td.disabled:hover {
            background: rgba(0, 0, 0, 0) !important;
            color: #eeeeee;
            cursor: not-allowed;
}

.input-group {
    padding-left: 0px !important;
}
</style>


<div class="row">
  <!-- left column -->
  <div class="col-md-7">
    <div class="box box-default">
    <!-- GRIFU | Modification. route the answer  -->
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
                <!-- GRIFU | Modification. Sending the user id to the user-select view -->

                @include ('partials.forms.edit.user-select', ['translated_name' => trans('general.user'), 'user_id' => $user->id,'fieldname' => 'assigned_user', 'required'=>'true'])
                @include ('partials.forms.edit.user-select', ['translated_name' => trans('general.responsible'), 'user_group' => '1','fieldname' => 'responsible', 'required'=>'true'])

                <!-- We have to pass unselect here so that we don't default to the asset that's being checked out. We want that asset to be pre-selected everywhere else. -->
                @include ('partials.forms.edit.asset-select', ['translated_name' => trans('general.asset'), 'fieldname' => 'assigned_asset', 'unselect' => 'true', 'style' => 'display:none;', 'required'=>'true'])

                @include ('partials.forms.edit.location-select', ['translated_name' => trans('general.location'), 'fieldname' => 'assigned_location', 'style' => 'display:none;', 'required'=>'true'])
                

              <!-- Checkout/Checkin Date  -->
              <div class="form-group {{ $errors->has('checkout_at') ? 'error' : '' }}">
                {{ Form::label('name', trans('admin/hardware/form.checkout_date'), array('class' => 'col-md-3 control-label')) }}
                
                <div class="col-md-8">
                    <div class='col-sm-6'>
                        <div class="form-group" data-provide="datetimepicker" data-date-format="yyyy-mm-dd HH:MM">
                            <div class='input-group date' id='checkout_at'>
                                <input type='text' class="form-control" placeholder="{{ trans('general.select_date') }}" name="checkout_at" value="{{ Input::old('checkout_at') }}">
                                <span class="input-group-addon"><i class="fa fa-calendar"></i></span>

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
                        <div class="form-group" data-provide="datetimepicker" data-date-format="yyyy-mm-dd HH:MM">
                            <div class='input-group date' id='expected_checkin'>
                                <input type='text'  class="form-control" placeholder="{{ trans('general.select_date') }}" name="expected_checkin" value="{{ Input::old('expected_checkin') }}" required>
                                <span class="input-group-addon"><i class="fa fa-calendar"></i></span>
                                </span>
                            </div>
                        </div>
                    </div>
                    {!! $errors->first('expected_checkin', '<span class="alert-msg"><i class="fa fa-times"></i> :message</span>') !!}
                </div>
            </div>


            <div class="form-group">
                <div class="col-sm-offset-3 col-sm-9">
                    <div class="checkbox">
                    <label>
                        <input type="checkbox" value="1" name="recurrent" id="recurrent" > {{ trans('admin/hardware/general.recurrent') }}
                        <input name="weeks" id="weeks" type="number" value="1" disabled>
                    {{ trans('admin/hardware/general.week') }}
                    </label>
                    </div>
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
          <button id="register" type="submit" class="btn btn-success pull-right"><i class="fa fa-check icon-white"></i> {{ trans('button.request') }}</button>
        </div>
      </form>
    </div>
  </div> <!--/.col-md-7-->

  <!-- right column -->
  <!-- <div class="col-md-5" id="current_assets_box" style="display:none;"> -->

  <div class="col-md-5" id="current_assets_box">
    <div class="box box-primary">
      <div class="box-header with-border">
        <h3 class="box-title">{{ trans('admin/users/general.asset_reservation') }}</h3>
      </div>
      <div class="box-body">
        <div id="current_assets_content">
            <p id="datas"></p>
        </div>
      </div>
    </div>
  </div>
</div>
@stop

@section('moar_scripts')
    @include('partials/assets-assigned')

    <!-- GRIFU | Modification-->
    <script>
        
        var msg = '{{Session::get('alert')}}';
    var exist = '{{Session::has('alert')}}';
    if(exist){
      alert(msg);
    }

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
        });

        // find closest value
        const findClosest = goal => (a,b) => Math.abs(a - goal) < Math.abs(b - goal) ? a : b;
        
        ///////////////////////////////////
        // Function to check if the default date is avaiable
        function checkDate(disableDates, defaultDate){
            while (disableDates.includes(defaultDate.format('YYYY-MM-DD'))) {
                // advance one day until is free
                defaultDate = moment(defaultDate).add(1, 'days');                
            }
            return defaultDate;
        }


        $(function()
        {
            $('#recurrent').on('click', function(){           
                if($(this).is(':checked')){
                    $('#weeks').attr('disabled', false);
                } else {
                    $('#weeks').attr('disabled', true);
                }
             });

            $('#recurrent').on('click', function(){
            // assuming the textarea is inside <div class="controls /">
            if($(this).is(':checked')){
                $('.controls input:text, .controls textarea').attr('disabled', true);
            } else {
                $('.controls input:text, .controls textarea').attr('disabled', false);
                }
          });


        });


        ///////////////////////////////////
        // returns the first time avaiable for the checkout reservation for the intended day (not today)
        function checkTime(defaultDate, checkouts, checkins, enableHours, inOut, checkinDate){

            // default date is de selected date
            // checkouts is an array of checkout reserved dates
            // checkins is an array of the checkin reserved dates
            // enableHours is the CheckinHours or the CheckoutHours

            ///////////////////////////////////
            // should optimize this to process all the data at the begining 
            // creating a vector with all the interval dates and hours avaiable
            // [day][avaiable hours]
            // then, just needed to find which date I have selected and restrict the enable hours and select the first hour

            
            var reservationHours = [];
            var whatCheck = false;  // false = checkout - true = checkin
            var dayAvaiable = -1;   // -1 is free, above 0 it is reserved 
            var avaiableCheckOutHour = 0;
            var avaiableCheckInHour = 0;            
    
            reservationHours.push.apply(reservationHours, enableHours);                        
                        
            // check if selected date is free - optimize this method with indexOf or Find, or Array.includes()
            checkouts.forEach(function(item, index){
                if(moment(defaultDate).format('YYYY-MM-DD') == item.format('YYYY-MM-DD')){
                    dayAvaiable = index;
                    whatCheck = false;
                }               
            });

            // if free, double check if today is a checkin date, if so, checkout is avaiable only after the checkin
            if(dayAvaiable < 0){                
                checkins.forEach(function(item, index){             
                if(moment(checkinDate).format('YYYY-MM-DD') == item.format('YYYY-MM-DD')){
                    dayAvaiable = index;
                    whatCheck = true;
                }
            });

            }   

            var avaiableHoursCheck = reservationHours;
            // there is a reservation for this day, let's disable these hours
            if(dayAvaiable >= 0){                
                if (!whatCheck) { 
                    
                    // restrict the checkout hour to all the aviable checkout hours and assign the default checkin
                    avaiableCheckOutHour = checkouts[dayAvaiable].format('HH'); // checkout hour of reservation
                    avaiableCheckInHour = checkins[dayAvaiable].format('HH'); // checkin hour of reservation
                    
                    // verificar se o checkin é depois da data                 
                    
                    avaiableHoursCheck = reservationHours.filter(function(x) {
                       // check if the reservation for the selected day is for multiple days
                       if(moment(checkins[dayAvaiable]).format('YYYY-MM-DD') > moment(checkouts[dayAvaiable]).format('YYYY-MM-DD')) {
                            return x < avaiableCheckOutHour;    // if there is more then one day of reservation the avaiable hor should be less than the reservation
                        } else {                            
                            return x < avaiableCheckOutHour ^ x > avaiableCheckInHour; // if the reserved date is only fot this day, than we can reserve before or after the reservation
                        }
                      });                                           
                } else {
                    
                    
                    // In case we are on the last day of a reservation, then we have to look into the checkin hour
                    // restrict the checkout hour to be after the checkin hour check out = checkin and the check in is the next
                    avaiableCheckOutHour = checkins[dayAvaiable].format('HH'); // checkout hour of reservation 
                    if(checkins.length >= dayAvaiable+1) avaiableCheckInHour = checkins[dayAvaiable].format('HH'); // checkin hour of reservation
                    avaiableHoursCheck = reservationHours.filter(function(x) {
                        return x > avaiableCheckInHour;
                      });                    
                 }
               
                //  var index_hours = reservationHours.indexOf(reservationHours.reduce(findClosest(avaiableCheckOutHour)));
                //  reservationHours.splice(index_hours,1);
            }
            
            // if checkin, lets filter the hours and the checkout is in the same day, the hour should be after the checkin
            if(inOut > 0){
                

                if(moment(defaultDate).format('YYYY-MM-DD') == moment(checkinDate).format('YYYY-MM-DD')) {     
                                 
                    avaiableHoursCheck = avaiableHoursCheck.filter(function(x) {                        
                    return x > moment(defaultDate).format('HH');     // this is for checkout
                 });                                 
                } else {
                    // Let's check if there is a checkout in this day

                    for (const date of checkouts) {   
                        if (moment(checkinDate).format('YYYY-MM-DD') == moment(date).format('YYYY-MM-DD')) {
                            avaiableHoursCheck = enableHours.filter(function(x) {                        
                                  return x < moment(date).format('HH');     // this is for checkout
                           });   
                            break;
                        }
                    }

                    /*
                    
                    

                    var index_day = checkouts.indexOf(checkouts.reduce(findClosest(moment(checkinDate).format('YYYY-MM-DD'))));   
                    
                    */
                   

                }
            }                                                
            return avaiableHoursCheck;
        }
        ///////////////////////////////////
        // returns the first time avaiable for the checkout reservation today related to the current time
        // this function should be combined with the checktime because their are similar
        function CheckTodaysDate(selectedCheckoutDate, avaiableCheckoutHours){

            // check if the first hour is greater than the current and if so, if the current hour before the next checkin of the checkout
            todaysDate = new Date();
            avaiableHours = avaiableCheckoutHours;

            // if we select today, lets retrieve the aviable hours for today
            if (moment(todaysDate).format('YYYY-MM-DD') == selectedCheckoutDate.format('YYYY-MM-DD')){
                avaiableHours = avaiableHours.filter(function(x) {
                    return x > moment(todaysDate).format('HH');     // this is for checkout
                });
            }            
            return avaiableHours;
        }
    
            // function AssignDefaultCheckin(selectedCheckout_at)
                // returns defaultExpectedChekin
                // 
                // function to retrieve new default checkin
                // need to send the selected checkout hour and probably the next checkout for today if exists
                // based on the selected checkout hour, assign the default checkin to the period greater than the checkout hour
                // if there is another checkout hour for this day after the selected checkin, the maxdate becomes that day (this can be done in the checktime....)

            ///////////////////////////////////
            // Assigns a default checkin hour
            function AssignDefaultCheckin(selectedCheckout_at, avaiableCheckinHours){
                
                // I need to retrieve that checkout hour to ensure that the checkin is after this hour, the same applyies to the date                
                // check only the hours above the selceted checkout
                
                
                
                avaiableHours = avaiableCheckinHours.filter(function(x) {
                        return x > moment(selectedCheckout_at).format('HH');     // this is for checkout
                    });                        
                    
                var nextAvaiableCheckinReservationPeriod = -1;
                
                if(avaiableHours.length > 0) {                    
                    var index_hours = avaiableHours.indexOf(avaiableHours.reduce(findClosest(moment(selectedCheckout_at).format('HH'))));   
                    nextAvaiableCheckinReservationPeriod = moment(selectedCheckout_at).set("hour", avaiableHours[index_hours]);      
                }
                      
                return nextAvaiableCheckinReservationPeriod;   // nearst hour from the checkout
            }

            function findClosestNextDate(arr,target){
                let targetDate = new Date(target);
                let previousDates = arr.filter(e => ( targetDate  - new Date(e)) < 0)
                let sortedPreviousDates =  previousDates.filter((a,b) => new Date(a) - new Date(b))
                  return sortedPreviousDates[0] || null
            }

            function sortDates(dates) {
                 return dates.map(function(date) {
                return new Date(date).getTime();
                }).sort(function(a, b) {
                return a - b;
                });
            }


            ///////////////////////////////////
            // Check the periods of reservation
            function CheckMaxCheckinDate(selectedCheckin, checkoutDisableDays){

                /*
                var indice=checkoutDisableDays.findIndex(function(checkoutDisableDays) {
                    return checkoutDisableDays > selectedCheckin;
                });         
                */
                var tempData = moment('2023-02-02');

                var orderedDates = sortDates(checkoutDisableDays);

                var nextDate = findClosestNextDate(orderedDates, selectedCheckin);
                
                if (nextDate == null) {
                    nextDate = false;
                }

                
                return nextDate;

/*
                console.log("data   ==== "+moment( nextDate).format('YYYY-MM-DD'));

                var nearDateIndex = selectedCheckin;
                if(checkoutDisableDays.length > 0) {                    
                    
                  //  nearDateIndex = checkoutDisableDays.indexOf(checkoutDisableDays.reduce(findClosest(selDate)));    
                  nearDateIndex = getClosestFutureDate(selectedCheckin, checkoutDisableDays);



                    

                }

                console.log("near ="+nearDateIndex);
                if(nearDateIndex > -1){
                    if(checkoutDisableDays[nearDateIndex] < selectedCheckin) {
                        nearDateIndex =checkoutDisableDays.findIndex(function(checkoutDisableDays) {
                         return checkoutDisableDays >= selectedCheckin;
                      });  
                     }
                }

                
                var maxCheckin = false;
                if(nearDateIndex >= 0) {
                    maxCheckin = checkoutDisableDays[nearDateIndex];
                } else {
                    maxCheckin = false;
                }
                console.log("selectedCheckin ="+moment(selectedCheckin).format('YYYY-MM-DD HH')+"DISABVLE DAYS ="+checkoutDisableDays+"MAX CHECKIN "+ moment(maxCheckin).format('YYYY-MM-DD HH'));
                return maxCheckin;
                */
            }


            ///////////////////////////////////
            // Check the periods of reservation
            function checkDateTime(disableDates, defaultDate, inBetween){

                // check if the proposed default day is avaiable, if not, it will advance one day until the date is free                
                //  checkoutAvaiableDay = checkDate(disableDates, defaultDate);            
                var avaiableHour = moment(defaultDate).format('HH');            
                // check if the selected hour is avaiable for reservation, make sure that the inbetween dates are not allowed
                while (!checkOutHours.some(value => { return value >= avaiableHour }) || inBetween.includes(defaultDate)){                      
                    defaultDate = moment(defaultDate).add(1, 'days');                    
                    defaultDate = moment(defaultDate).set("hour", checkOutHours[0]);
                    
                    // verify if the day is not disable
                    decheckoutAvaiableDayfaultDate = checkDate(disableDates, defaultDate);
                    avaiableHour = moment(defaultDate).format('HH');
                }

             
                var newHour=[];
                for(i=0; i < checkOutHours.length; i++){
                    newHour.push(Math.abs(avaiableHour-checkOutHours[i]));
                }

                var indexHour = newHour.indexOf(Math.min.apply(Math,newHour ));
                var checkoutDefaultHour = checkOutHours[indexHour];

                //moment(checkoutAvaiableDay).add(moment.duration(checkoutDefaultHour)).toDate();
                defaultDate = moment(defaultDate).set("hour", checkoutDefaultHour).set("minute", 0);                 

                return defaultDate;
            }


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


            // GRIFU | Modification. This should be defined dynamically, in a preferences page. 
            const checkOutHours = [9,14,18]; // Define which hours we can checkout
            const checkInHours = [8,13,17,23];  // Define which hours we can checkin
            // this constraint presents issues and should be solved in the future.
            // if we choose a specific hour for checkout in a future day and this hour is not avaiable for today, then, today becomes disable and does not allows us to choose a different hour!!!!

            var enableCheckOutHours = checkOutHours;

            // import dates from controller - This is used for the reservations only
            var array = JSON.parse('{!! json_encode($store) !!}');
            
            
            // GRIFU | Modification
            // Check if all these variables are really in use, review the var naming and calling

            var defaultCheckout = new Date(); // user selected date for checkout
            var defaultCheckin = defaultCheckout;

            var selectedCheckout = defaultCheckout;
            var selectedChecin = defaultCheckin;

            var reserved_checkout = []; // vector with reservation checkout dates
            var reserved_checkin = [];  // vector with reservation checkin dates
            var inBetweenDays = [];

            var enableCheckInHours = checkInHours;
            var CheckinMaxDate = false;
            var closeDatas = new Date("2029-09-12");        // infinit

            var checkoutAvaiableDay = new Date();   //today
        

            // Define disable days and convert dates to IsoDates for the calendar
            var ISOdate = [];   
            var dates = [];

            var curDate = new Date();   // todays day, which can be increased if this day is not avaiable
            
            array.forEach(function(item){
                var startDate = moment(item['expected_checkout']);
                var stopDate = moment(item['expected_checkin']);
            
                reserved_checkout.push(startDate);
                reserved_checkin.push(stopDate);
                
                // gather the two arrays into multidimensional array for showing in the interface
                dates.push([moment(startDate), moment(stopDate)]);                              

                if (moment(stopDate).format('YYYY-MM-DD') >= moment(startDate).format('YYYY-MM-DD')){
                                        
                    // Check if the reservation is longer than one day
                    // disable dates because they are entire days in between the reservation dates
                    
                    numDays = Math.round(moment.duration(stopDate.diff(startDate)).asDays());
                    
                    if(numDays >= 1){
                        var reservationToday = false;                        
                        
                        // check if checkout is for today                       
                        if(moment(startDate).format('YYYY-MM-DD') == moment(curDate).format('YYYY-MM-DD')){    
                            reservationToday = true;                       
                            // check if there is avaiable hours for reservation in this day           
                            // assuming that this is the checkout date and there are more than one day of reservation, so we cannot make a reservation after the reserved hour, and          
                            if (Math.round(moment(curDate).format('HH')) > Math.round(moment(startDate).format('HH')) || Math.round(moment(startDate).format('HH')) <= checkOutHours[0]){   
                              
                                ISOdate.push(moment(startDate).format('YYYY-MM-DD'));     
                                                     
                            } 
                        }                         
                        var disableDay = 0;
                        
                        // check the inbetween days they should be 
                        for (var i=0; i < numDays; i++){       
                            if(i>0){                                                       
                                disableDay = moment(startDate).add(i, 'days');                                                                                     
                                inBetweenDays.push(moment(disableDay).format('YYYY-MM-DD'));    // this is a inbetween day                                                       
                                ISOdate.push(moment(disableDay).format('YYYY-MM-DD'));  // vector that olds the days to be disable
                             } else {
                                 // check if we are in the first day, if so, check if theare are hours avaiable
                                if (Math.round(moment(startDate).format('HH')) <= Math.round(checkOutHours.slice(-1)) && !reservationToday){  
                                    
                                    disableDay = moment(startDate).add(i, 'days');                           
                                     ISOdate.push(moment(disableDay).format('YYYY-MM-DD'));  // vector that olds the days to be disable
                                  }     
                             }                             

                            // Check if the next disable date is the current data and it is not today ,
                            if (moment(disableDay).format('YYYY-MM-DD') == moment(curDate).format('YYYY-MM-DD') && !reservationToday) {                             
                                defaultCheckout = moment(disableDay).add(1, 'days').format('YYYY-MM-DD');                                   
                                checkoutAvaiableDay = defaultCheckout;
                                curDate = defaultCheckout;    // make today the new avaiable day to check if is avaiable in the next loop                                    
                            }                                                                                    
                        }                       
                        // check if the last day of reservation is avaiable for other reservations
                        if (Math.round(moment(stopDate).format('HH')) >= Math.round(checkOutHours.slice(-1))){                           
                            ISOdate.push(moment(stopDate).format('YYYY-MM-DD'));
                            
                        }                     



                        // if the date is today, and if the hour is less than the first checkout, let's move ahead
                        if(moment(curDate).format('YYYY-MM-DD') == moment(startDate).format('YYYY-MM-DD')){
                            // let's check if this is a multi-day reservation                            
                            if (moment(stopDate).format('YYYY-MM-DD') > moment(startDate).format('YYYY-MM-DD')){
                                // check if today's hour is above the checkout hour, if so, we must move to the date of the checkin
                               var currentHour = Math.round(moment(curDate).format('HH'));
                               // check the avaiable hours for this day before the checkout
                                var checkoutAvaiableHourBefore = checkOutHours.filter(function(x) {
                                     return x < moment(startDate).format('HH');
                                 });

                               // returns the checkout hour before the checkout of the reservation 
                                var previousHoursCheckout = checkoutAvaiableHourBefore.filter(function (hourCheck){
                                    return hourCheck <= moment(startDate).format('HH');
                                });
                                var previousHour = Math.max.apply(null,previousHoursCheckout );                                

                                // if the current hour is after the checkout or if the current hour is greater than the avaiable checkout hour 
                                if (currentHour > previousHour){
                                    // we have to jump to the stopDate and increase the hour on checkout to be after the checkin                                    
                                    defaultCheckout = moment(stopDate).format('YYYY-MM-DD');
                                    checkoutAvaiableDay = defaultCheckout;                               
                                }
                            }
                        }

                 

                           
                        
                    } else {
                                                
                        //Math.round(moment.duration(stopDate.diff(startDate)).asDays());
                        // check if the day is avaiable for other reservations or if the reservation is for all day
                        if ((Math.round(moment(startDate).format('HH')) < Math.round(checkOutHours[1])) && (Math.round(moment(stopDate).format('HH')) >= Math.round(checkOutHours.slice(-1)))){
                            ISOdate.push(moment(startDate).format('YYYY-MM-DD'));
                            if (moment(startDate).format('YYYY-MM-DD') == moment(curDate).format('YYYY-MM-DD')) { 
                                defaultCheckout = moment(startDate).add(1, 'days').format('YYYY-MM-DD');
                                
                                checkoutAvaiableDay = defaultCheckout;
                                curDate = checkoutAvaiableDay; // make today the new avaiable day to check if is avaiable in the next loop
                                
                            } 
                        } 
                    }                    
                }                
            });
    

            // shows reservation dates in the interface in order
        dates.sort(function (element_a, element_b) {
                return element_a[0] - element_b[0];
            });
            
        dates.forEach(function(item,index){
                document.getElementById("datas").innerHTML = document.getElementById("datas").innerHTML+" <br> "+"{{ trans('admin/users/general.from') }} "+moment(item[0]).format('DD-MM-YY HH:mm')+" {{ trans('admin/users/general.till') }} "+moment(item[1]).format('DD-MM-YY HH:mm');
            });
            

            var $datesArray = ISOdate.map( dateString => new Date(dateString) );

            // the default check out day can't be today if: today's hour is greater then the last defined checkout, if the avaiable hours are already filled for today, or if today is disable
            // if today is no avaiable should search alternative day for the default day            
            
           // checkoutAvaiableDay = moment(checkoutAvaiableDay);
            selectedCheckout = checkoutAvaiableDay;
            
            // simulates specific date for developing
            //checkoutAvaiableDay = moment(checkoutAvaiableDay).add(19, 'days');


            // prevent user to edit the date manually
            $('#checkout_at').keydown(function(e) {
                e.preventDefault();
            });
            $('#expected_checkin').keydown(function(e) {
                e.preventDefault();
            });
            

            //checkoutAvaiableDay = checkDateTime(ISOdate, defaultCheckout, inBetweenDays);
            var checkAvaiable = checkDateTime(ISOdate, defaultCheckout, inBetweenDays);                    
            enableCheckOutHours = checkTime(checkAvaiable, reserved_checkout, reserved_checkin, checkOutHours, 0, defaultCheckin);            
           
                        
            // Can't retrieve the date directly, so let's find the closest date 
            if(defaultCheckin <= defaultCheckout){                
                
                var checkAvaiableHours = enableCheckOutHours.filter(function(x) {
                        return x >= moment(defaultCheckout).format('HH');
                      });                  
                //var indexAvaiableCheckout = enableCheckOutHours.indexOf(enableCheckOutHours.reduce(findClosest(defaultCheckout)));                                
                 //var aproxDefaultCheckout = moment(checkAvaiable).set("hour", enableCheckOutHours[indexAvaiableCheckout]);                                                   
         
                 enableCheckInHours = checkTime(moment(checkAvaiable).set("hour", checkAvaiableHours[0]), reserved_checkout, reserved_checkin, checkInHours, 1, defaultCheckin);
                 defaultCheckin = moment(defaultCheckin).set("hour", enableCheckInHours[0]);                                  
                 
            } else {
                 // find the next avaibale checkin hour based on checkout hour
            enableCheckInHours = checkTime(defaultCheckout, reserved_checkout, reserved_checkin, checkInHours, 1, defaultCheckin);
            }
            
            
            // define the default checkin date
            var checkinDefaultValue = AssignDefaultCheckin(checkAvaiable, enableCheckInHours);
            if (checkinDefaultValue > -1) defaultCheckin = checkinDefaultValue;
                        
            // define the max checkin date
            closeDatas = CheckMaxCheckinDate(checkAvaiable, reserved_checkout);
            

            $('#checkout_at').datetimepicker({
            locale: 'pt', // Extract this from the language selection          
            minDate: checkoutAvaiableDay,  // today date
            disabledDates: ISOdate,
            format: 'YYYY-MM-DD HH:00',   
            sideBySide: true,            
            enabledHours: enableCheckOutHours,
            });
            


            // change the checkout calendar
            $("#checkout_at").on("dp.change", function (e) {
                defaultCheckout = moment(e.date.toDate()).format('YYYY-MM-DD HH');
                var checkoutReading = defaultCheckout;
                // Retrieves the checkout hours avaiable for the selected date
                enableCheckOutHours = checkTime(defaultCheckout, reserved_checkout, reserved_checkin, checkOutHours, 0, defaultCheckin);
                // there is no selection, this should be the default checkout hour                
                if(enableCheckOutHours.length == 1) {
                    defaultCheckout = moment(defaultCheckout).set("hour", enableCheckOutHours[0]);                    
                }
                
                // check if the day or month changed, if so, let's select the first avaiable hour
                if (moment(selectedCheckout).format('YYYY-MM-DD') != moment(defaultCheckout).format('YYYY-MM-DD'))  {
                                        
                    // always choose the first avaiable hour                                         
                    defaultCheckout = moment(defaultCheckout).set("hour", enableCheckOutHours[0]);                 
                    $("#checkout_at").data("DateTimePicker").date(moment(defaultCheckout).format('YYYY-MM-DD HH'));
                    selectedCheckout = defaultCheckout;                                       
                    enableCheckInHours = checkTime(defaultCheckout, reserved_checkout, reserved_checkin, checkInHours, 1, defaultCheckout);                                    
                    checkinDefaultValue = AssignDefaultCheckin(checkoutReading, enableCheckInHours);  
                    if (checkinDefaultValue > -1) defaultCheckin = checkinDefaultValue;
    
                    $('#expected_checkin').data("DateTimePicker").maxDate(false); 
                   // defaultCheckin = defaultCheckout;

                   // if(moment(defaultCheckin).format('YYYY-MM-DD HH') <= moment(defaultCheckin).format('YYYY-MM-DD HH')) {
                        $('#expected_checkin').data("DateTimePicker").minDate(moment(defaultCheckin).format('YYYY-MM-DD HH'));                                                                
                         $("#expected_checkin").data("DateTimePicker").date(moment(defaultCheckin).format('YYYY-MM-DD HH'));
                   // }
                   

                    closeDatas = CheckMaxCheckinDate(defaultCheckout, reserved_checkout);  
                   // $('#expected_checkin').data("DateTimePicker").maxDate(closeDatas);   


                } else if (moment(selectedCheckout).format('YYYY-MM-DD HH') != moment(defaultCheckout).format('YYYY-MM-DD HH')) {
                    
                
                    tempCheckout = $('#checkout_at').data('date');                                        
                    enableCheckInHours = checkTime(tempCheckout, reserved_checkout, reserved_checkin, checkInHours, 1, defaultCheckin);                                        
                    checkinDefaultValue = AssignDefaultCheckin(tempCheckout, enableCheckInHours);  
                    if (checkinDefaultValue > -1) defaultCheckin = checkinDefaultValue;
                    closeDatas = CheckMaxCheckinDate(tempCheckout, reserved_checkout);   
                    $('#expected_checkin').data("DateTimePicker").maxDate(closeDatas);                     
                   // defaultCheckin = defaultCheckout;
                    $("#expected_checkin").data("DateTimePicker").date(moment(defaultCheckin).format('YYYY-MM-DD HH:mm')); 
                  
                } else {
                 //   $('#expected_checkin').data("DateTimePicker").minDate(false); 
                }                            
                $('#checkout_at').data("DateTimePicker").enabledHours(enableCheckOutHours);                                                
                closeDatas = closeDate($datesArray, defaultCheckout);                                
                // reset of checkin max date
             //   $('#expected_checkin').data("DateTimePicker").maxDate(false); 
            
            });




                // When it clicks in checkout
            $('#checkout_at').on("dp.update", function (e) {
                
             //   $('#checkout_at').data("DateTimePicker").minDate(selectedCheckout);
                return false;
            });



            // When it clicks in checkout
            $('#checkout_at').click(function() {
                $('#EventDateStart').val('');
                $('#EventDateEnd').val('');
                return false;
            });




            // When it shows the checkin calendar
            $('#expected_checkin').on("dp.change", function (e) {
                defaultCheckout = $("#checkout_at").data("DateTimePicker").date();
                defaultCheckin = moment(e.date.toDate()).format('YYYY-MM-DD HH');
               
                if(moment(defaultCheckout).format('YYYY-MM-DD') != moment(defaultCheckin).format('YYYY-MM-DD')) {
                    
                    defaultCheckin = moment(defaultCheckin).set("hour", enableCheckInHours[0]);  
                    $("#expected_checkin").data("DateTimePicker").date(moment(defaultCheckin).format('YYYY-MM-DD HH:mm')); 
                }
                               
                enableCheckInHours = checkTime(defaultCheckout, reserved_checkout, reserved_checkin, checkInHours, 1, defaultCheckin);
          //      $('#expected_checkin').data("DateTimePicker").enabledHours(enableCheckInHours);
                
                
                $('#expected_checkin').data("DateTimePicker").enabledHours(enableCheckInHours);

             //   closeDatas = CheckMaxCheckinDate(defaultCheckout, reserved_checkout); 
                 
            });

            $('#expected_checkin').on("dp.update", function (e) {
                
                $('#expected_checkin').data("DateTimePicker").enabledHours(enableCheckInHours);
                
            });

            $('#expected_checkin').click(function() {
                
                defaultCheckout = $("#checkout_at").data("DateTimePicker").date();
                // BIMBO
     //           defaultCheckin = $("#expected_checkin").data("DateTimePicker").date();
                var mCheckin = moment(defaultCheckin, 'YYYY-MM-DD');
                if(!mCheckin.isValid())  { 
                    defaultCheckin = defaultCheckout;
                }

                enableCheckInHours = checkTime(defaultCheckout, reserved_checkout, reserved_checkin, checkInHours, 1, defaultCheckin);   

                

                checkinDefaultValue = AssignDefaultCheckin(defaultCheckout, enableCheckInHours);
                if (checkinDefaultValue > -1) defaultCheckin = checkinDefaultValue;
                
                
                $('#expected_checkin').data("DateTimePicker").enabledHours(enableCheckInHours);

                // CheckMaxCheckinDate(moment(closeDatas, 'YYYY-MM-DD'));

                closeDatas = moment(CheckMaxCheckinDate(defaultCheckout, reserved_checkout)); 
                $('#expected_checkin').data("DateTimePicker").maxDate(closeDatas); 

                
                var m = moment(closeDatas, 'YYYY-MM-DD');
                
                if(m.isValid())  { 
                
                    // if the date is not today                
                  
                    $('#expected_checkin').data("DateTimePicker").minDate(defaultCheckout); 
                    $('#expected_checkin').data("DateTimePicker").maxDate(closeDatas); 
                    defaultCheckin = defaultCheckout;

                    if(Date("y-m-d", closeDatas) != new Date())
                    {                    
                    //   $('#expected_checkin').data("DateTimePicker").maxDate(closeDatas-1);
                    } else
                    {
                    //$('#expected_checkin').data("DateTimePicker").maxDate(moment(closeDatas).add(1, 'days'));                    
                    //  $('#expected_checkin').data("DateTimePicker").maxDate(moment(closeDatas-1));
                        
                    } 
                   // CheckinMaxDate = closeDatas-1;
                   
                   // $('#expected_checkin').data("DateTimePicker").minDate(defaultCheckout); 
                   // $('#expected_checkin').data("DateTimePicker").maxDate(moment(closeDatas));
                //    defaultCheckin = defaultCheckout;

                } else{             
                    // the returned date is not valid    
                    $('#expected_checkin').data("DateTimePicker").minDate(false);    
                    $('#expected_checkin').data("DateTimePicker").maxDate(false); 
                    defaultCheckin = false;
                    
                } 
                

            //   $('#expected_checkin').data("DateTimePicker").minDate(false);
            
                return false;
            });



            // GRIFU | Modification
            $('#expected_checkin').datetimepicker({

                locale: 'pt', // Extract this from the language selection
                disabledDates: ISOdate,
                minDate: defaultCheckin,
                sideBySide: true,
                maxDate: closeDatas,
            //   daysOfWeekDisabled: [0, 6],  // this should be set in the configuration 
                format: 'YYYY-MM-DD HH:00',
                enabledHours: enableCheckInHours,
           //     defaultDate: checkas,
                useCurrent: false //<--- this change

            });


            // With useCurrent = false, the dates and hours work well, but for the default there is no expected checkin

    </script>




@stop


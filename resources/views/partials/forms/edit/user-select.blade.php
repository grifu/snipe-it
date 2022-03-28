<div id="assigned_user" class="form-group{{ $errors->has($fieldname) ? ' has-error' : '' }}"{!!  (isset($style)) ? ' style="'.e($style).'"' : ''  !!}>
    
    <!-- GRIFU | Modification -->

   @if (!empty($user_id))
   {{ Form::label($fieldname, $translated_name, array('class' => 'col-md-3 control-label')) }}
       <option value="{{ $user_id }}" selected="selected">
           {{ $user_name = (\App\Models\User::find($user_id)) ? \App\Models\User::find($user_id)->present()->fullName : '' }}
       </option>
       <!-- GRIFU | Modification. this should not be a paragraph -->
       <p> {{ $user_name }} </p>

   @else
   
       {{ Form::label($fieldname, $translated_name, array('class' => 'col-md-3 control-label')) }}
   
       <div class="col-md-7{{  ((isset($required)) && ($required=='true')) ? ' required' : '' }}">     
           @if ($fieldname == 'responsible')
               <select class="js-data-ajax" data-endpoint="responsible" data-placeholder="{{ trans('general.select_user') }}" name="{{ $fieldname }}" style="width: 100%" id="{{ (isset($user_id)) ? $user_id : '1' }}" required>
           @else
               
                @if (!empty($userRequest_id))

                    <select class="js-data-ajax" data-endpoint="users" data-placeholder="{{ trans('general.select_user') }}" name="{{ $fieldname }}" style="width: 100%" id="{{ $userRequest_id }}" >
                @else
                    <select class="js-data-ajax" data-endpoint="users" data-placeholder="{{ trans('general.select_user') }}" name="{{ $fieldname }}" style="width: 100%" id="{{ (isset($user_id)) ? $user_id : '1' }}" >
                 @endif

           @endif
           @if (!empty($userRequest_id))    
                <option value="{{ $userRequest_id }}" selected="selected">
                    {{ $user_name = (\App\Models\User::find($userRequest_id)) ? \App\Models\User::find($userRequest_id)->present()->fullName : '' }}
                </option>
            @else
                @if ($user_id = Input::old($fieldname, (isset($item)) ? $item->{$fieldname} : ''))
                            <option value="{{ $userRequest_id }}" selected="selected">
                                {{ $user_name = (\App\Models\User::find($userRequest_id)) ? \App\Models\User::find($userRequest_id)->present()->fullName : '' }}
                            </option>
                @else
                    <option value="">{{ trans('general.select_user') }}</option>
                @endif
            @endif  
       </select>
   </div>
   

   <div class="col-md-1 col-sm-1 text-left">
       @can('create', \App\Models\User::class)
           @if ((!isset($hide_new)) || ($hide_new!='true'))
               <a href='{{ route('modal.user') }}' data-toggle="modal"  data-target="#createModal" data-select='assigned_user_select' class="btn btn-sm btn-default">New</a>
           @endif
       @endcan
   </div>
   @endif
   {!! $errors->first($fieldname, '<div class="col-md-8 col-md-offset-3"><span class="alert-msg"><i class="fa fa-times"></i> :message</span></div>') !!}

</div>
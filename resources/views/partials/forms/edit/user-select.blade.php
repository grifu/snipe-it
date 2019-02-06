<div id="assigned_user" class="form-group{{ $errors->has($fieldname) ? ' has-error' : '' }}"{!!  (isset($style)) ? ' style="'.e($style).'"' : ''  !!}>  
    {{ Form::label($fieldname, $translated_name, array('class' => 'col-md-3 control-label')) }}

    <div class="col-md-7{{  ((isset($required)) && ($required=='true')) ? ' required' : '' }}">

    

        <select class="js-data-ajax" data-endpoint="users" data-placeholder="{{ trans('general.select_user') }}" name="{{ $fieldname }}" style="width: 100%" id="{{ (isset($user_id)) ? $user_id : '1' }}" >

    
            
               <!-- GRIFU:  this value is passed through requestou.blade.php-->
                @if (!empty($user_id))
                <option value="{{ $user_id }}" selected="selected">
                    <!--$users = DB::table('users')->select('name', 'email as user_email')->get();-->
                        {{ (\App\Models\User::find($user_id)) ? \App\Models\User::find($user_id)->present()->fullName : '' }}
                    </option>
                @endif
                
                <!-- GRIFU:  Temporary - This should be implemented to filter users within just a group-->
                @if (!empty($group_id))
                <option label="responsible" value="{{ $group_id }}" selected="selected">
                        {{ (\App\Models\Group::where('id', 1)->get()) ? \App\Models\User::find($group_id)->present()->fullName : '' }}
                    </option>

                    @else
                        @if ($user_id = Input::old($fieldname, (isset($item)) ? $item->{$fieldname} : ''))
                        <option value="{{ $user_id }}" selected="selected">
                            {{ (\App\Models\User::find($user_id)) ? \App\Models\User::find($user_id)->present()->fullName : '' }}
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

    {!! $errors->first($fieldname, '<div class="col-md-8 col-md-offset-3"><span class="alert-msg"><i class="fa fa-times"></i> :message</span></div>') !!}

</div>

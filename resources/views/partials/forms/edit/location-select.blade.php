<!-- Location -->
<div id="{{ $fieldname }}" class="form-group{{ $errors->has($fieldname) ? ' has-error' : '' }}"{!!  (isset($style)) ? ' style="'.e($style).'"' : ''  !!}>

    {{ Form::label($fieldname, $translated_name, array('class' => 'col-md-3 control-label')) }}
    <div class="col-md-7{{  ((isset($required) && ($required =='true'))) ?  ' required' : '' }}">
        <select class="js-data-ajax" data-endpoint="locations" data-placeholder="{{ trans('general.select_location') }}" name="{{ $fieldname }}" style="width: 100%" id="{{ $fieldname }}_location_select">
            @if ($location_id = Input::old($fieldname, (isset($item)) ? $item->{$fieldname} : ''))
                <option value="{{ $location_id }}" selected="selected">
                    {{ (\App\Models\Location::find($location_id)) ? \App\Models\Location::find($location_id)->name : '' }}
                </option>
            @else
                <option value="">{{ trans('general.select_location') }}</option>
            @endif
        </select>
    </div>

    <div class="col-md-1 col-sm-1 text-left">
        @can('create', \App\Models\Location::class)
            @if ((!isset($hide_new)) || ($hide_new!='true'))
            <a href='{{ route('modal.location') }}' data-toggle="modal"  data-target="#createModal" data-select='{{ $fieldname }}_location_select' class="btn btn-sm btn-default">New</a>
            @endif
        @endcan
    </div>

    {!! $errors->first($fieldname, '<div class="col-md-8 col-md-offset-3"><span class="alert-msg"><i class="fa fa-times"></i> :message</span></div>') !!}

    @if (isset($help_text))
    <div class="col-md-7 col-sm-11 col-md-offset-3">
        <p class="help-block">{{ $help_text }}</p>
    </div>
    @endif


</div>




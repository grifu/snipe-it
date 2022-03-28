@extends('layouts/default')

{{-- Page title --}}
@section('title')
  @if ($item->id)
    {{ trans('admin/asset_maintenances/form.update') }}
  @else
    {{ trans('admin/asset_maintenances/form.create') }}
  @endif
  @parent
@stop


@section('header_right')
<a href="{{ URL::previous() }}" class="btn btn-primary pull-right">
  {{ trans('general.back') }}</a>
@stop


{{-- Page content --}}
@section('content')

<div class="row">
  <div class="col-md-9">
    @if ($item->id)
      <form class="form-horizontal" method="post" action="{{ route('maintenances.update', $item->id) }}" autocomplete="off">
      {{ method_field('PUT') }}
    @else
      <form class="form-horizontal" method="post" action="{{ route('maintenances.store') }}" autocomplete="off">
    @endif
    <!-- CSRF Token -->
    {{ csrf_field() }}

    <div class="box box-default">
      <div class="box-header with-border">
        <h3 class="box-title">
          @if ($item)
          {{ $item->name }}
          @endif
        </h3>
      </div><!-- /.box-header -->

      <div class="box-body">
        @include ('partials.forms.edit.asset-select', ['translated_name' => trans('admin/asset_maintenances/table.asset_name'), 'fieldname' => 'asset_id', 'required' => 'true'])
        @include ('partials.forms.edit.supplier-select', ['translated_name' => trans('general.supplier'), 'fieldname' => 'supplier_id', 'required' => 'true'])
        @include ('partials.forms.edit.maintenance_type')

        <!-- Title -->
        <div class="form-group {{ $errors->has('title') ? ' has-error' : '' }}">
          <label for="title" class="col-md-3 control-label">
            {{ trans('admin/asset_maintenances/form.title') }}
          </label>
          <div class="col-md-7{{  (\App\Helpers\Helper::checkIfRequired($item, 'title')) ? ' required' : '' }}">
            <input class="form-control" type="text" name="title" id="title" value="{{ Input::old('title', $item->title) }}" />
            {!! $errors->first('title', '<span class="alert-msg"><i class="fa fa-times"></i> :message</span>') !!}
          </div>
        </div>

        <!-- Start Date -->
        <div class="form-group {{ $errors->has('start_date') ? ' has-error' : '' }}">
          <label for="start_date" class="col-md-3 control-label">{{ trans('admin/asset_maintenances/form.start_date') }}</label>

          <div class="input-group col-md-3{{  (\App\Helpers\Helper::checkIfRequired($item, 'start_date')) ? ' required' : '' }}">
            <div class="input-group date" data-provide="datepicker" data-date-format="yyyy-mm-dd"  data-autoclose="true">
              <input type="text" class="form-control" placeholder="{{ trans('general.select_date') }}" name="start_date" id="start_date" value="{{ Input::old('start_date', $item->start_date) }}">
              <span class="input-group-addon"><i class="fa fa-calendar"></i></span>
            </div>
            {!! $errors->first('start_date', '<span class="alert-msg"><i class="fa fa-times"></i> :message</span>') !!}
          </div>
        </div>



        <!-- Completion Date -->
        <div class="form-group {{ $errors->has('completion_date') ? ' has-error' : '' }}">
          <label for="start_date" class="col-md-3 control-label">{{ trans('admin/asset_maintenances/form.completion_date') }}</label>

          <div class="input-group col-md-3{{  (\App\Helpers\Helper::checkIfRequired($item, 'completion_date')) ? ' required' : '' }}">
            <div class="input-group date" data-provide="datepicker" data-date-format="yyyy-mm-dd"  data-autoclose="true">
              <input type="text" class="form-control" placeholder="{{ trans('general.select_date') }}" name="completion_date" id="completion_date" value="{{ Input::old('completion_date', $item->completion_date) }}">
              <span class="input-group-addon"><i class="fa fa-calendar"></i></span>
            </div>
            {!! $errors->first('completion_date', '<span class="alert-msg"><i class="fa fa-times"></i> :message</span>') !!}
          </div>
        </div>

        <!-- Warranty -->
        <div class="form-group">
          <div class="col-sm-offset-3 col-sm-9">
            <div class="checkbox">
              <label>
                <input type="checkbox" value="1" name="is_warranty" id="is_warranty" {{ Input::old('is_warranty', $item->is_warranty) == '1' ? ' checked="checked"' : '' }}> {{ trans('admin/asset_maintenances/form.is_warranty') }}
              </label>
            </div>
          </div>
        </div>

        <!-- Asset Maintenance Cost -->
        <div class="form-group {{ $errors->has('cost') ? ' has-error' : '' }}">
          <label for="cost" class="col-md-3 control-label">{{ trans('admin/asset_maintenances/form.cost') }}</label>
          <div class="col-md-2">
            <div class="input-group">
              <span class="input-group-addon">
                @if (($item->asset) && ($item->asset->location) && ($item->asset->location->currency!=''))
                  {{ $item->asset->location->currency }}
                @else
                  {{ $snipeSettings->default_currency }}
                @endif
              </span>
              <input class="col-md-2 form-control" type="text" name="cost" id="cost" value="{{ Input::old('cost', \App\Helpers\Helper::formatCurrencyOutput($item->cost)) }}" />
              {!! $errors->first('cost', '<span class="alert-msg"><i class="fa fa-times"></i> :message</span>') !!}
            </div>
          </div>
        </div>

        <!-- Notes -->
        <div class="form-group {{ $errors->has('notes') ? ' has-error' : '' }}">
          <label for="notes" class="col-md-3 control-label">{{ trans('admin/asset_maintenances/form.notes') }}</label>
          <div class="col-md-7">
            <textarea class="col-md-6 form-control" id="notes" name="notes">{{ Input::old('notes', $item->notes) }}</textarea>
            {!! $errors->first('notes', '<span class="alert-msg"><i class="fa fa-times"></i> :message</span>') !!}
          </div>
        </div>
      </div> <!-- .box-body -->

      <div class="box-footer text-right">
        <button type="submit" class="btn btn-success"><i class="fa fa-check icon-white"></i> {{ trans('general.save') }}</button>
      </div>
    </div> <!-- .box-default -->
    </form>
  </div>
</div>

@stop

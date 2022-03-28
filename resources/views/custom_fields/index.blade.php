@extends('layouts/default')

{{-- Page title --}}
@section('title')
  Manage {{ trans('admin/custom_fields/general.custom_fields') }}
@parent
@stop

@section('content')

@can('view', \App\Models\CustomFieldset::class)
<div class="row">
  <div class="col-md-9">
    <div class="box box-default">

      <div class="box-header with-border">
        <h3 class="box-title">{{ trans('admin/custom_fields/general.fieldsets') }}</h3>
        <div class="box-tools pull-right">
          @can('create', \App\Models\CustomFieldset::class)
          <a href="{{ route('fieldsets.create') }}" class="btn btn-sm btn-primary" data-toggle="tooltip" title="Create a new fieldset">{{ trans('admin/custom_fields/general.create_fieldset') }}</a>
          @endcan
        </div>
      </div><!-- /.box-header -->

      <div class="box-body">
        <table
                data-cookie-id-table="customFieldsetsTable"
                data-id-table="customFieldsetsTable"
                data-search="true"
                data-side-pagination="client"
                data-show-columns="true"
                data-show-export="true"
                data-show-refresh="true"
                data-sort-order="asc"
                data-sort-name="name"
                id="customFieldsTable"
                class="table table-striped snipe-table"
                data-export-options='{
                "fileName": "export-fieldsets-{{ date('Y-m-d') }}",
                "ignoreColumn": ["actions","image","change","checkbox","checkincheckout","icon"]
                }'>
          <thead>
            <tr>
              <th>{{ trans('general.name') }}</th>
              <th>{{ trans('admin/custom_fields/general.qty_fields') }}</th>
              <th>{{ trans('admin/custom_fields/general.used_by_models') }}</th>
              <th></th>
            </tr>
          </thead>

          @if(isset($custom_fieldsets))
          <tbody>
            @foreach($custom_fieldsets AS $fieldset)
            <tr>
              <td>
                {{ link_to_route("fieldsets.show",$fieldset->name,['id' => $fieldset->id]) }}
              </td>
              <td>
                {{ $fieldset->fields->count() }}
              </td>
              <td>
                @foreach($fieldset->models as $model)
                  <a href="{{ route('models.show', $model->id) }}" class="label label-default">{{ $model->name }}</a>

                @endforeach
              </td>
              <td>
                @can('delete', $fieldset)
                {{ Form::open(['route' => array('fieldsets.destroy', $fieldset->id), 'method' => 'delete']) }}
                  @if($fieldset->models->count() > 0)
                  <button type="submit" class="btn btn-danger btn-sm disabled" disabled><i class="fa fa-trash"></i></button>
                  @else
                  <button type="submit" class="btn btn-danger btn-sm"><i class="fa fa-trash"></i></button>
                  @endif
                {{ Form::close() }}
                @endcan
              </td>
            </tr>
            @endforeach
          </tbody>
          @endif
        </table>
      </div><!-- /.box-body -->
    </div><!-- /.box.box-default -->

  </div> <!-- .col-md-9-->
  <!-- side address column -->
  <div class="col-md-3">
    <h4>{{ trans('admin/custom_fields/general.about_fieldsets_title') }}</h4>
    <p>{{ trans('admin/custom_fields/general.about_fieldsets_text') }} </p>
  </div>
</div> <!-- .row-->
@endcan
@can('view', \App\Models\CustomField::class)
<div class="row">
  <div class="col-md-12">
    <div class="box box-default">
      <div class="box-header with-border">
        <h3 class="box-title">{{ trans('admin/custom_fields/general.custom_fields') }}</h3>
        <div class="box-tools pull-right">
          @can('create', \App\Models\CustomField::class)
          <a href="{{ route('fields.create') }}" class="btn btn-sm btn-primary" data-toggle="tooltip" title="Create a new custom field">{{ trans('admin/custom_fields/general.create_field') }}</a>
          @endcan
        </div>

      </div><!-- /.box-header -->
      <div class="box-body">

        <div class="table-responsive">
        <table
                data-cookie-id-table="customFieldsTable"
                data-id-table="customFieldsTable"
                data-search="true"
                data-side-pagination="client"
                data-show-columns="true"
                data-show-export="true"
                data-show-refresh="true"
                data-sort-order="asc"
                data-sort-name="name"
                id="customFieldsTable"
                class="table table-striped snipe-table"
                data-export-options='{
                "fileName": "export-fields-{{ date('Y-m-d') }}",
                "ignoreColumn": ["actions","image","change","checkbox","checkincheckout","icon"]
                }'>
          <thead>
            <tr>
              <th data-searchable="true">{{ trans('general.name') }}</th>
              <th data-searchable="true">Help Text</th>
              <th data-searchable="true">Email</th>
              <th data-visible="false">DB Field</th>
              <th data-searchable="true">{{ trans('admin/custom_fields/general.field_format') }}</th>
              <th data-searchable="true">{{ trans('admin/custom_fields/general.field_element_short') }}</th>
              <th data-searchable="true">{{ trans('admin/custom_fields/general.fieldsets') }}</th>
              <th></th>
            </tr>
          </thead>
          <tbody>
            @foreach($custom_fields as $field)
            <tr>
              <td>{{ $field->name }}</td>
              <td>{{ $field->help_text }}</td>
              <td>{!! ($field->show_in_email=='1') ? '<i class="fa fa-check text-success"></i>' : '<i class="fa fa-times text-danger"></i>'  !!}</td>
              <td>
                 <code>{{ $field->convertUnicodeDbSlug() }}</code>
                @if ($field->convertUnicodeDbSlug()!=$field->db_column)
                  <br><i class="fa fa-warning text-danger"></i>WARNING. This field is in the custom fields table as <code>{{  $field->db_column }}</code> but should be <code>{{ $field->convertUnicodeDbSlug() }}</code>.
                @endif
              </td>
              <td>{{ $field->format }}</td>
              <td>{{ $field->element }}</td>
              <td>
                @foreach($field->fieldset as $fieldset)
                  <a href="{{ route('fieldsets.show', $fieldset->id) }}" class="label label-default">{{ $fieldset->name }}</a>
                @endforeach
              </td>
              <td>
                <nobr>
                  @can('update', $field)
                <a href="{{ route('fields.edit', $field->id) }}" class="btn btn-warning btn-sm"><i class="fa fa-pencil"></i></a>
                @endcan               
                @can('delete', $field)
                {{ Form::open(array('route' => array('fields.destroy', $field->id), 'method' => 'delete', 'style' => 'display:inline-block')) }}
                @if($field->fieldset->count()>0)
                <button type="submit" class="btn btn-danger btn-sm disabled" disabled><i class="fa fa-trash"></i></button>
                @else
                <button type="submit" class="btn btn-danger btn-sm"><i class="fa fa-trash"></i></button>
                @endif
                {{ Form::close() }}
                @endcan
                </nobr>
              </td>
            </tr>
            @endforeach
          </tbody>
        </table>
        </div>
      </div><!-- /.box-body -->
    </div><!-- /.box -->
  </div> <!-- /.col-md-9-->
</div>
@endcan

@stop
@section('moar_scripts')
  @include ('partials.bootstrap-table')
@stop

@extends('layouts/default')

{{-- Page title --}}
@section('title')
    {{ trans('general.audit_report') }}
    @parent
@stop

{{-- Page content --}}
@section('content')

    <div class="row">
        <div class="col-md-12">
            <div class="box box-default">
                <div class="box-body">

                    <table
                            data-cookie-id-table="auditReport"
                            data-pagination="true"
                            data-id-table="auditReport"
                            data-search="true"
                            data-side-pagination="server"
                            data-show-columns="true"
                            data-show-export="true"
                            data-show-refresh="true"
                            data-sort-order="asc"
                            id="auditReport"
                            data-url="{{ route('api.activity.index', ['action_type' => 'audit']) }}"
                            class="table table-striped snipe-table"
                            data-export-options='{
                        "fileName": "activity-report-{{ date('Y-m-d') }}",
                        "ignoreColumn": ["actions","image","change","checkbox","checkincheckout","icon"]
                        }'>

                        <thead>
                        <tr>
                            <th class="col-sm-1" data-field="image" data-visible="false" data-formatter="imageFormatter">{{ trans('admin/hardware/table.image') }}</th>
                            <th class="col-sm-2" data-field="created_at" data-formatter="dateDisplayFormatter">{{ trans('general.audit') }}</th>
                            <th class="col-sm-2" data-field="admin" data-formatter="usersLinkObjFormatter">{{ trans('general.admin') }}</th>
                            <th class="col-sm-2" data-field="item" data-formatter="polymorphicItemFormatter">{{ trans('general.item') }}</th>
                            <th class="col-sm-1" data-field="location" data-formatter="locationsLinkObjFormatter">{{ trans('general.location') }}</th>
                            <th class="col-sm-2" data-field="next_audit_date" data-formatter="dateDisplayFormatter">{{ trans('general.next_audit_date') }}</th>
                            <th class="col-sm-1" data-field="days_to_next_audit">{{ trans('general.days_to_next_audit') }}</th>

                            <th class="col-sm-2" data-field="note">{{ trans('general.notes') }}</th>
                        </tr>
                        </thead>
                    </table>
                </div>
            </div>
        </div>
    </div>
@stop


@section('moar_scripts')
    @include ('partials.bootstrap-table')
@stop

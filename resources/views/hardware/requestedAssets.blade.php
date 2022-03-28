@extends('layouts/default')

@can('checkout', \App\Models\Asset::class)
    {!! $userCheckout = '1' !!}
@else
    {!! $userCheckout = '0' !!}
@endcan

@section('title0')
  {{ trans('admin/hardware/general.requested') }}
  {{ trans('general.assets') }}
@stop

{{-- Page title --}}
@section('title')
    @yield('title0')  @parent
@stop



{{-- Page content --}}
@section('content')
    <div class="row">
        <div class="col-md-12">
            <div class="box">
                <div class="box-body">
                    {{ Form::open([
                      'method' => 'POST',
                      'route' => ['hardware/bulkedit'],
                      'class' => 'form-inline',
                       'id' => 'bulkForm']) }}
                    <div class="row">
                        <div class="col-md-12">

        @if ($requestedAssets->count() > 0)
        <div class="table-responsive">
            <table
                    name="requestedAssets"
                    data-toolbar="#toolbar"
                    class="table table-striped snipe-table"
                    id="requestedAssets"
                    data-advanced-search="true"
                    data-search="true"
                    data-show-columns="true"
                    data-show-export="true"
                    data-pagination="true"
                    data-id-table="requestedAssets"
                    data-cookie-id-table="requestedAssets"
                    data-url="{{ route('api.consumables.index') }}"
                    data-export-options='{
                    "fileName": "export-assetrequests-{{ date('Y-m-d') }}",
                    "ignoreColumn": ["actions","image","change","checkbox","checkincheckout","icon"]
                    }'>
                <thead>
                    <tr role="row">
                        <th class="col-md-1">Image</th>
                        <th class="col-md-2">Item Name</th>
                        <th class="col-md-2" data-sortable="true">{{ trans('admin/hardware/table.location') }}</th>
                        <th class="col-md-2">Responsavel</th>
                        <th class="col-md-3" data-sortable="true">Requisitante/th>
                        <th class="col-md-2" data-sortable="true">Levantamento</th>
                        <th class="col-md-2" data-sortable="true">{{ trans('admin/hardware/form.expected_checkin') }}</th>
                        <th class="col-md-2">Estado</th>
                        <th class="col-md-2">Cancelar</th>
                        <th class="col-md-2">Levantar/Devolver</th>
                        <th class="col-md-1"></th>
                        <th class="col-md-1"></th>
                    </tr>
                </thead>
                <tbody>


                
                 
                    @foreach ($requestedAssets as $requests)
                    <!-- GRIFU | Modification. detect if exists -->
                        @if (\App\Models\Asset::where('id', $requests->asset_id)->exists())
                        <!-- GRIFU | Modification. detect if it is not deleted -->
                            @if( \App\Models\Asset::find($requests->asset_id)['deleted_at'] == null)
                             @if ($userCheckout == '1' || $requests->user_id == $user->id || $requests->responsible_id == $user->id)
                                <tr>
                                    {{ csrf_field() }}
                                    
            
                                        <td>
                                        
                                            @if ($requests->checkoutRequests->itemType() == "asset_model" || $requests->checkoutRequests->itemType() == "asset")
                                                @if (\App\Models\Asset::find($requests->asset_id)->getImageUrl() != null )
                                                    <a href="{{ \App\Models\Asset::find($requests->asset_id)->getImageUrl() }}" data-toggle="lightbox" data-type="image"><img src="{{ \App\Models\Asset::find($requests->asset_id)->getImageUrl() }}" style="max-height: {{ $snipeSettings->thumbnail_max_h }}px; width: auto;" class="img-responsive"></a>
                                                @endif
                                                @elseif (($requests->checkoutRequests->itemType() == "asset_model") && ($requests->checkoutRequests->requestable))
                                                    @if (\App\Models\Asset::find($requests->asset_id)->getImageUrl() != null )    
                                                        <a href="{{ url('/') }}/uploads/models/{{ \App\Models\Asset::find($requests->asset_id)->image }}" data-toggle="lightbox" data-type="image"><img src="{{ url('/') }}/uploads/models/{{ \App\Models\Asset::find($requests->asset_id)->image }}" style="max-height: {{ $snipeSettings->thumbnail_max_h }}px; width: auto;" class="img-responsive"></a>
                                                    @endif
                                            @endif

                                        </td>
                                        
                                        <td>
                                            

                                        @if ($requests->checkoutRequests->itemType() == "asset" || $requests->checkoutRequests->itemType() == "asset_model")
                                            @if (\App\Models\Asset::find($requests->asset_id)->getImageUrl() != null ) 
                                                <a href="{{ url('/') }}/hardware/{{ $requests->asset_id }}">
                                                    {{ \App\Models\Asset::find($requests->asset_id)->name }}
                                                </a>
                                            @endif  
                                        @elseif ($requests->checkoutRequests->itemType() == "asset_model_futura_implementacao_quando_for_possivel_reservar_modelos" )
                                            @if (\App\Models\Asset::find($requests->asset_id)->getImageUrl() != null ) 
                                                <a href="{{ url('/') }}/models/{{ $requests->asset_id }}">
                                                    {{ \App\Models\Asset::find($requests->asset_id)->name }}
                                                </a>
                                            @endif       
                                        @endif
                                            
                                        </td>

                                        <!-- GRIFU | Modification. detected if it is not null -->
                                        @if($requests->checkoutRequests['location_id'] !=null)
                                            @if ($requests->checkoutRequests->location())
                                            <td>{{ $requests->checkoutRequests->location() }}</td>
                                            @else
                                            <td></td>
                                            @endif
                                        @else
                                            <td></td>
                                        @endif
                                        

                                        <td>
                                        
                                            @if ($requests->requestingResponsible() != null)
                                            <a href="{{ url('/') }}/users/{{ $requests->requestingResponsible()->id }}">
                                                {{ $requests->requestingResponsible()->present()->fullName() }}
                                            </a>
                                            @else
                                                (deleted user)
                                            @endif
                                        </td>



                                        <td>
                                            @if ($requests->user_id)
                                                <a href="{{ url('/') }}/users/{{ $requests->user_id }}">
                                                    {{ \App\Models\User::find($requests->user_id)->present()->fullName() }}
                                                </a>
                                            @else
                                                (deleted user)
                                            @endif
                                            
                                        </td>

                                        <td>{{ App\Helpers\Helper::getFormattedDateObject($requests->expected_checkout, 'datetime', false) }}</td>

                                        <td>{{ App\Helpers\Helper::getFormattedDateObject($requests->expected_checkin, 'datetime', false) }}</td>


                                        <td>
                                            @if ($requests->requestingResponsible() != null)
                                                @if (($requests->request_state == 0) && ($requests->requestingResponsible()->id == $user->id))
                                                    <a href="{{ url('/') }}/account/aproverequest/{{ $requests->id }}/aprove" class="btn btn-success" data-tooltip="true" title="Approve this request">Aprovar</a>
                                                    <a href="{{ url('/') }}/account/aproverequest/{{ $requests->id }}/disaprove" class="btn btn-danger" data-tooltip="true" title="Disapprove this request">Recusar</a>
                                                @elseif ($requests->request_state == 0)
                                                    
                                                        <a href="{{ url('/') }}/account/aproverequest/{{ $requests->id }}" class="label label-warning" data-tooltip="true" title="A aguardar aprovação">Aguardando</a>

                                                @elseif ($requests->request_state == 1)
                                                
                                                    @if( $userCheckout == 1)
                                                        @if(isset($requests->asset_id))
                                                            <span class="label label-sm bg-success" data-tooltip="true" title="item aprovado">Aprovado</span>
                                                        @endif
                                                    @endif
                                                @endif
                                            @endif
                                        </td>

                                        <td>
                                            
                                            @if ($requests->request_state == 0 || $requests->request_state == 1) 
                                                @if (($requests->user_id == $user->id) || ($userCheckout = '1'))
                                                <a href="{{ url('/') }}/account/aproverequest/{{ $requests->id }}/cancel" class="btn btn-danger" data-tooltip="true" title={{ trans('button.cancel') }}>{{ trans('button.cancel') }}</a>
                                                @endif
                                            @endif
                                            
                                        </td>
                                    
                                        <td>                                    
                                            @if( $userCheckout == 1)
                                                
                                                @if ($requests->checkoutRequests->itemType() == "asset" || $requests->checkoutRequests->itemType() == "asset_model")
                                                    @if ($requests->request_state == 1)
                                                    
                                                        @if (\App\Models\Asset::find($requests->asset_id)->assigned_to == null)
                                                            <a href="{{ url('/') }}/hardware/{{ $requests->asset_id }}/checkoutRequest/{{ $requests->id }}" class="btn btn-sm bg-maroon" data-tooltip="true" title="Check this item out to a user">{{ trans('general.checkout') }}</a>
                                                        @endif
                                                    @endif
                                                @endif
                                            @endif
                                        </td>


                                </tr>
                             @endif
                            @endif
                        @endif
                    @endforeach
               


                </tbody>
            </table>
        </div>

        @else
        <div class="col-md-12">
            <div class="alert alert-info alert-block">
                <i class="fa fa-info-circle"></i>
                {{ trans('general.no_results') }}
            </div>
        </div>
        @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div> <!-- .col-md-12> -->
</div> <!-- .row -->
@stop

@section('moar_scripts')
    @include ('partials.bootstrap-table', [
        'exportFile' => 'requested-export',
        'search' => true,
        'clientSearch' => true,
    ])

@stop

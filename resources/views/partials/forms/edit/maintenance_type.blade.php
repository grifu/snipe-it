          <!-- Improvement Type -->
          <div class="form-group {{ $errors->has('asset_maintenance_type') ? ' has-error' : '' }}">
              <label for="asset_maintenance_type" class="col-md-3 control-label">{{ trans('admin/asset_maintenances/form.asset_maintenance_type') }}
              </label>
              <div class="col-md-7{{  (\App\Helpers\Helper::checkIfRequired($item, 'asset_maintenance_type')) ? ' required' : '' }}">
                  {{ Form::select('asset_maintenance_type', $assetMaintenanceType , Input::old('asset_maintenance_type', $item->asset_maintenance_type), ['class'=>'select2', 'style'=>'min-width:350px']) }}
                  {!! $errors->first('asset_maintenance_type', '<span class="alert-msg"><i class="fa fa-times"></i> :message</span>') !!}
              </div>
          </div>
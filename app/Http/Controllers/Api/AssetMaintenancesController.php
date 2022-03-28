<?php
namespace App\Http\Controllers\Api;

use App\Helpers\Helper;
use App\Http\Controllers\Controller;
use App\Http\Transformers\AssetMaintenancesTransformer;
use App\Models\Asset;
use App\Models\AssetMaintenance;
use App\Models\Company;
use Auth;
use Carbon\Carbon;
use Gate;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;

/**
 * This controller handles all actions related to Asset Maintenance for
 * the Snipe-IT Asset Management application.
 *
 * @version    v2.0
 */
class AssetMaintenancesController extends Controller
{


    /**
     *  Generates the JSON response for asset maintenances listing view.
     *
     * @see AssetMaintenancesController::getIndex() method that generates view
     * @author  Vincent Sposato <vincent.sposato@gmail.com>
     * @version v1.0
     * @since [v1.8]
     * @return String JSON
     */
    public function index(Request $request)
    {
        $maintenances = AssetMaintenance::with('asset', 'supplier', 'asset.company', 'admin');

        if (Input::has('search')) {
            $maintenances = $maintenances->TextSearch(e($request->input('search')));
        }

        if ($request->has('asset_id')) {
            $maintenances->where('asset_id', '=', $request->input('asset_id'));
        }

        $offset = request('offset', 0);
        $limit = request('limit', 50);

        $allowed_columns = [
                                'id',
                                'title',
                                'asset_maintenance_time',
                                'asset_maintenance_type',
                                'cost',
                                'start_date',
                                'completion_date',
                                'notes',
                                'asset_tag',
                                'asset_name',
                                'user_id'
                            ];
        $order = Input::get('order') === 'asc' ? 'asc' : 'desc';
        $sort = in_array(Input::get('sort'), $allowed_columns) ? e($request->input('sort')) : 'created_at';

        switch ($sort) {
            case 'user_id':
                $maintenances = $maintenances->OrderAdmin($order);
                break;
            case 'asset_tag':
                $maintenances = $maintenances->OrderByTag($order);
                break;
            case 'asset_name':
                $maintenances = $maintenances->OrderByAssetName($order);
                break;
            default:
                $maintenances = $maintenances->orderBy($sort, $order);
                break;
        }

        $total = $maintenances->count();
        $maintenances = $maintenances->skip($offset)->take($limit)->get();
        return (new AssetMaintenancesTransformer())->transformAssetMaintenances($maintenances, $total);


    }


    /**
     *  Validates and stores the new asset maintenance
     *
     * @see AssetMaintenancesController::getCreate() method for the form
     * @author  Vincent Sposato <vincent.sposato@gmail.com>
     * @version v1.0
     * @since [v1.8]
     * @return String JSON
     */
    public function store(Request $request)
    {
        // create a new model instance
        $assetMaintenance = new AssetMaintenance();
        $assetMaintenance->supplier_id = $request->input('supplier_id');
        $assetMaintenance->is_warranty = $request->input('is_warranty');
        $assetMaintenance->cost =  e($request->input('cost'));
        $assetMaintenance->notes = e($request->input('notes'));
        $asset = Asset::find(e($request->input('asset_id')));

        if (!Company::isCurrentUserHasAccess($asset)) {
            return response()->json(Helper::formatStandardApiResponse('error', null, 'You cannot add a maintenance for that asset'));
        }

        // Save the asset maintenance data
        $assetMaintenance->asset_id               = $request->input('asset_id');
        $assetMaintenance->asset_maintenance_type = $request->input('asset_maintenance_type');
        $assetMaintenance->title                  = $request->input('title');
        $assetMaintenance->start_date             = $request->input('start_date');
        $assetMaintenance->completion_date        = $request->input('completion_date');
        $assetMaintenance->user_id                = Auth::id();

        if (( $assetMaintenance->completion_date !== null )
            && ( $assetMaintenance->start_date !== "" )
            && ( $assetMaintenance->start_date !== "0000-00-00" )
        ) {
            $startDate                                = Carbon::parse($assetMaintenance->start_date);
            $completionDate                           = Carbon::parse($assetMaintenance->completion_date);
            $assetMaintenance->asset_maintenance_time = $completionDate->diffInDays($startDate);
        }

        // Was the asset maintenance created?
        if ($assetMaintenance->save()) {
            return response()->json(Helper::formatStandardApiResponse('success', $assetMaintenance, trans('admin/asset_maintenances/message.create.success')));

        }

        return response()->json(Helper::formatStandardApiResponse('error', null, $assetMaintenance->getErrors()));

    }


    /**
     *  Validates and stores an update to an asset maintenance
     *
     * @author  A. Gianotto <snipe@snipe.net>
     * @param int $assetMaintenanceId
     * @param int $request
     * @version v1.0
     * @since [v4.0]
     * @return String JSON
     */
    public function update(Request $request, $assetMaintenanceId = null)
    {
        // Check if the asset maintenance exists
        $assetMaintenance = AssetMaintenance::findOrFail($assetMaintenanceId);

        if (!Company::isCurrentUserHasAccess($assetMaintenance->asset)) {
            return response()->json(Helper::formatStandardApiResponse('error', null, 'You cannot edit a maintenance for that asset'));
        }

        $assetMaintenance->supplier_id = e($request->input('supplier_id'));
        $assetMaintenance->is_warranty = e($request->input('is_warranty'));
        $assetMaintenance->cost =  Helper::ParseFloat(e($request->input('cost')));
        $assetMaintenance->notes = e($request->input('notes'));

        $asset = Asset::find(request('asset_id'));

        if (!Company::isCurrentUserHasAccess($asset)) {
            return response()->json(Helper::formatStandardApiResponse('error', null, 'You cannot edit a maintenance for that asset'));
        }

        // Save the asset maintenance data
        $assetMaintenance->asset_id               = $request->input('asset_id');
        $assetMaintenance->asset_maintenance_type = $request->input('asset_maintenance_type');
        $assetMaintenance->title                  = $request->input('title');
        $assetMaintenance->start_date             = $request->input('start_date');
        $assetMaintenance->completion_date        = $request->input('completion_date');

        if (( $assetMaintenance->completion_date == null )
        ) {
            if (( $assetMaintenance->asset_maintenance_time !== 0 )
                || ( !is_null($assetMaintenance->asset_maintenance_time) )
            ) {
                $assetMaintenance->asset_maintenance_time = null;
            }
        }

        if (( $assetMaintenance->completion_date !== null )
            && ( $assetMaintenance->start_date !== "" )
            && ( $assetMaintenance->start_date !== "0000-00-00" )
        ) {
            $startDate                                = Carbon::parse($assetMaintenance->start_date);
            $completionDate                           = Carbon::parse($assetMaintenance->completion_date);
            $assetMaintenance->asset_maintenance_time = $completionDate->diffInDays($startDate);
        }

        // Was the asset maintenance created?
        if ($assetMaintenance->save()) {

            return response()->json(Helper::formatStandardApiResponse('success', $assetMaintenance, trans('admin/asset_maintenances/message.edit.success')));

        }
        return response()->json(Helper::formatStandardApiResponse('error', null, $assetMaintenance->getErrors()));
    }

    /**
     *  Delete an asset maintenance
     *
     * @author  A. Gianotto <snipe@snipe.net>
     * @param int $assetMaintenanceId
     * @version v1.0
     * @since [v4.0]
     * @return String JSON
     */
    public function destroy($assetMaintenanceId)
    {
        // Check if the asset maintenance exists
        $assetMaintenance = AssetMaintenance::findOrFail($assetMaintenanceId);

        if (!Company::isCurrentUserHasAccess($assetMaintenance->asset)) {
            return response()->json(Helper::formatStandardApiResponse('error', null, 'You cannot delete a maintenance for that asset'));
        }

        $assetMaintenance->delete();

        return response()->json(Helper::formatStandardApiResponse('success', $assetMaintenance, trans('admin/asset_maintenances/message.delete.success')));


    }

    /**
     *  View an asset maintenance
     *
     * @author  A. Gianotto <snipe@snipe.net>
     * @param int $assetMaintenanceId
     * @version v1.0
     * @since [v4.0]
     * @return String JSON
     */
    public function show($assetMaintenanceId)
    {
        $assetMaintenance = AssetMaintenance::findOrFail($assetMaintenanceId);
        if (!Company::isCurrentUserHasAccess($assetMaintenance->asset)) {
            return response()->json(Helper::formatStandardApiResponse('error', null, 'You cannot view a maintenance for that asset'));
        }
        return (new AssetMaintenancesTransformer())->transformAssetMaintenance($assetMaintenance);

    }
}

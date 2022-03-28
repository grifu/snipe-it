<?php
namespace App\Http\Controllers;

use App\Models\Accessory;
use App\Models\Actionlog;
use App\Models\Asset;
use App\Models\AssetModel;
use App\Models\CheckoutRequest;
use App\Models\RequestedAsset;
use App\Models\Company;
use App\Models\Component;
use App\Models\Consumable;
use App\Models\License;
use App\Models\Setting;
use App\Models\User;
use App\Notifications\RequestAssetNotification;
use App\Notifications\RequestAssetCancelationNotification;
use App\Notifications\RequestAssetApprovalNotification;
use Auth;
use Config;
use DB;
use Input;
use Lang;
use Mail;
use Redirect;
use Slack;
use Validator;
use View;
use Illuminate\Http\Request;


/**
 * This controller handles all actions related to the ability for users
 * to view their own assets in the Snipe-IT Asset Management application.
 *
 * @version    v1.0
 */
class ViewAssetsController extends Controller
{
    /**
     * Redirect to the profile page.
     *
     * @return Redirect
     */
    public function getIndex()
    {

        $user = User::with(
            'assets.model',
            'consumables',
            'accessories',
            'licenses',
            'userloc',
            'userlog'
        )->withTrashed()->find(Auth::user()->id);


        $userlog = $user->userlog->load('item', 'user', 'target');

        if (isset($user->id)) {
            return view('account/view-assets', compact('user', 'userlog'));
        } else {
            // Prepare the error message
            $error = trans('admin/users/message.user_not_found', compact('id'));

            // Redirect to the user management page
            return redirect()->route('users.index')->with('error', $error);
        }

    }


    public function getRequestableIndex()
    {

        $assets = Asset::with('model', 'defaultLoc', 'location', 'assignedTo', 'requests')->Hardware()->RequestableAssets()->get();
        $models = AssetModel::with('category', 'requests', 'assets')->RequestableModels()->get();

        return view('account/requestable-assets', compact('user', 'assets', 'models'));
    }



    public function getRequestItem($itemType, $itemId = null)
    {
        $item = null;
        $fullItemType = 'App\\Models\\' . studly_case($itemType);

        if ($itemType == "asset_model") {
            $itemType = "model";
        }
        $item = call_user_func(array($fullItemType, 'find'), $itemId);

        $user = Auth::user();


        $logaction = new Actionlog();
        $logaction->item_id = $data['asset_id'] = $item->id;
        $logaction->item_type = $fullItemType;
        $logaction->created_at = $data['requested_date'] = date("Y-m-d H:i:s");

        if ($user->location_id) {
            $logaction->location_id = $user->location_id;
        }
        $logaction->target_id = $data['user_id'] = Auth::user()->id;
        $logaction->target_type = User::class;

        $data['item_quantity'] = Input::has('request-quantity') ? e(Input::get('request-quantity')) : 1;
        $data['requested_by'] = $user->present()->fullName();
        $data['item'] = $item;
        $data['item_type'] = $itemType;
        $data['target'] = Auth::user();


        if ($fullItemType == Asset::class) {
            $data['item_url'] = route('hardware.show', $item->id);
        } else {
            $data['item_url'] = route("view/${itemType}", $item->id);

        }

        $settings = Setting::getSettings();

        if ($item_request = $item->isRequestedBy($user)) {
           $item->cancelRequest();

           $data['item_quantity'] = $item_request->qty;
           $logaction->logaction('request_canceled');

            if (($settings->alert_email!='')  && ($settings->alerts_enabled=='1') && (!config('app.lock_passwords'))) {
                $settings->notify(new RequestAssetCancelationNotification($data));
            }

            return redirect()->route('requestable-assets')->with('success')->with('success', trans('admin/hardware/message.requests.canceled'));

        } else {
            $item->request();
            if (($settings->alert_email!='')  && ($settings->alerts_enabled=='1') && (!config('app.lock_passwords'))) {
                $logaction->logaction('requested');
                $settings->notify(new RequestAssetNotification($data));
            }



            

            return redirect()->route('requestable-assets')->with('success')->with('success', trans('admin/hardware/message.requests.success'));
        }
    }





    // GRIFU | Modification
    public function getRequestView($assetId = null)
    {        
       $settings = Setting::getSettings();
       $logaction = new Actionlog();
       $logaction->item_id = $data['asset_id'] = $assetId;
       $logaction->item_type = $data['item_type'] = Asset::class;
       $logaction->created_at = $data['requested_date'] = date("Y-m-d H:i:s");

      // $requested_Asset = new requested_assets();
       $user = Auth::user();

       // Check if the asset exists and is requestable
       if (is_null($asset = Asset::RequestableAssets()->find($assetId))) {

           return redirect()->route('requestable-assets')
               ->with('error', trans('admin/hardware/message.does_not_exist_or_not_requestable'));
       } elseif (!Company::isCurrentUserHasAccess($asset)) {
           return redirect()->route('requestable-assets')
               ->with('error', trans('general.insufficient_permissions'));
       }

       $data['item'] = $asset;
       $data['target'] =  Auth::user();
       $data['item_quantity'] = 1;
       $settings = Setting::getSettings();



      if ($asset->isRequestedBy(Auth::user())) {
            
        $asset->cancelRequest();
        $asset->decrement('requests_counter', 1);

        
        // GRIFU | Modification. This function should be transposed to Requestable.php
        $requestedAsset = new RequestedAsset;
        $requestedAsset->where('checkout_requests_id',CheckoutRequest::all()->last()->id)->update(array('request_state' => '3'));

        $logaction->logaction('request canceled');
        $settings->notify(new RequestAssetCancelationNotification($data));
        return redirect()->route('requestable-assets')
            ->with('success')->with('success', trans('admin/hardware/message.requests.cancel-success'));
            
    } else {

       

       
        
        // GRIFU | Modification
        // retrieve groups that are able to aprove reservations
        // $search = '"assets.responsible":"1"';
        // $userResponsibleGroup =  DB::table('groups')->where('permissions', 'LIKE', '%'.$search.'%')->pluck('id');
        // Get User ID's
        // $userResponsibleIDs =  DB::table('users_groups')->whereIn('group_id', $userResponsibleGroup)->pluck('user_id');

        // Should not access directly to table, please change to model
        // need to check if there is a inbetween reservation for today
        $store =  DB::table('requested_assets')->where('asset_id',$assetId)->where('expected_checkin', '>=', date('Y-m-d'))->where('request_state', '<','2')->select('expected_checkout','expected_checkin')->get();
        
        
        // Function to retrieve the allocated date and to add to the reservations preventing the reservation in a date that the object is allocated        
        if ($asset->expected_checkin !=null) {
        
            $expected = $asset->where('id',$assetId)->select('last_checkout','expected_checkin')->get();
            $tmp = date($expected[0]->expected_checkin);
            unset($expected[0]->expected_checkin);
            $expected[0]->expected_checkout = date($expected[0]->last_checkout);
            unset($expected[0]->last_checkout);
            $expected[0]->expected_checkin = $tmp;

            $store->push($expected[0]); // It adds to the vector the expected chekin date
            
        }

        // Send a list of responsible users and reservation dates to view requestout.blade
        // return View::make('hardware/requestout', compact('asset'))->with('store', $store)->with('Responsibles', $userResponsibleIDs);
        return View::make('hardware/requestout', compact('asset'))->with('store', $store);
     
    }          
    
    }

    function extend($obj, $obj2) {
        $vars = get_object_vars($obj2);
        foreach ($vars as $var => $value) {
            $obj->$var = $value;
        }
        return $obj;
    }

// Function to request approval
// GRIFU | Modification
public function requestAssetApproval($requestId  = null)
{
    $requestedAsset = new RequestedAsset;
    $user = Auth::user();
    return 'request ID ='.$requestId;
}

 
    

// -----------------------
// GRIFU | Modification. This method aproves or disaproves the requests
public function approveRequestAsset($requestId  = null, $request = null)
{
    $requestedAsset = new RequestedAsset;
    $user = Auth::user();
    $request_state = 0;     // waiting
    $requestedAsset->find($requestId);

    
    $settings = Setting::getSettings();
    $logaction = new Actionlog();
    $logaction->item_id = $requestId;
    if ($user->location_id) {
        $logaction->location_id = $user->location_id;
    }
    $logaction->target_id = $data['user_id'] = Auth::user()->id;
    $logaction->target_type = User::class;

    // GRIFU | Modification. Temporarily, to accept/aprove a request by default using mail.
    // Not the best implementation and lacks security
    if($request == null) $request = 'aprove';

    if(($request == 'disaprove') || ($request == 'cancel') || ($request == 'aprove')) 
    {
        // This should be a model - in the top call use model 
        $assetRequested = DB::table('requested_assets')->where('id', $requestId)->first();
        $assetId =  DB::table('requested_assets')->where('id', $requestId)->pluck('asset_id');
    

        if (is_null($asset = Asset::find($assetId))) 
        {
             // Redirect to the asset management page with error
             return redirect()->route('hardware.index')->with('error', trans('admin/hardware/message.does_not_exist'));
        }

        // Verify if the user who is validating is in fact the responsible user 
        $isResponsible = False;
        if($assetRequested->responsible_id == $user->id) $isResponsible = True;

        
        $targetUser =  User::find( $assetRequested->user_id);

        $data['asset_id'] = $assetId;
        $data['item'] = $asset[0];
        $data['target'] =  $targetUser;
        $data['item_quantity'] = 1;
        $data['note'] = '';
        $data['check_out'] = $assetRequested->expected_checkout;
        $data['check_in'] = $assetRequested->expected_checkin;
        $data['expected_checkin'] = $assetRequested->expected_checkin;
        $data['requested_date'] = date("Y-m-d H:i:s");
        $data['last_checkout'] = date("Y-m-d H:i:s");
        $data['request_id'] = $requestId;
        $data['item_type'] = Asset::class;

        $logaction->item_id = $data['asset_id'];
        $logaction->created_at = date("Y-m-d H:i:s");

        
        if(($request == 'disaprove' && $isResponsible == true) || ($request == 'cancel')) {
            
            

            
            $targetUser->notify(new RequestAssetCancelationNotification($data));

            if($request == 'disaprove') {
                $request_state = 2;     // disaprobed state
                $logaction->logaction('request_not_approved');
            } else if($request == 'cancel') {
                $logaction->logaction('request_canceled');
                $request_state = 3;     //  cancel state  
            }
            
            
            

        } else if($request == 'aprove' && $isResponsible == true) {


             // request_state = 3 is canceled, request_state = 4 is allocated
            if ($assetRequested->request_state >= 3) {
                 return redirect()->route('hardware.index')->with('error', trans('admin/hardware/message.canceled')); 
             }

            // GRIFU - send notification
            $targetUser->notify(new RequestAssetApprovalNotification($data));

            $logaction->logaction('request_approved');
            $request_state = 1;     // Aproved request
        
        } else
        {
            // it's not the responsible user
            return redirect()->back()->with('error')->with('error', trans('admin/hardware/message.requests.error'));
        }
    }


    $requestedAsset->where('id',$requestId)->update(array('request_state' => $request_state));

    return redirect()->back()->with('success')->with('success', trans('admin/hardware/message.requests.success'));
   return null;
}

// GRIFU | Modification -- Process the reservation 
    public function getRequestAsset($assetId = null)
    {

        $requestedAsset = new RequestedAsset;
        $user = Auth::user();

        // Check if the asset exists and is requestable
        if (is_null($asset = Asset::RequestableAssets()->find($assetId))) {
            return redirect()->route('requestable-assets')
                ->with('error', trans('admin/hardware/message.does_not_exist_or_not_requestable'));
        } elseif (!Company::isCurrentUserHasAccess($asset)) {
            return redirect()->route('requestable-assets')
                ->with('error', trans('general.insufficient_permissions'));
        }

        if (e(Input::get('responsible')) == null) 
        {
            return redirect()->route('requestable-assets')
                        ->with('error', trans('admin/hardware/message.no_responsible'));
        } else 
        {
            // GRIFU - Check if the responsible user does have permissions
            $search = '"assets.responsible":"1"';
            $userResponsibleGroup =  DB::table('groups')->where('permissions', 'LIKE', '%'.$search.'%')->pluck('id');
            $userResponsibleIDs =  DB::table('users_groups')->whereIn('group_id', $userResponsibleGroup)->pluck('user_id')->toArray();
            if (!in_array(e(Input::get('responsible')), $userResponsibleIDs)) 
            {
                return redirect()->route('requestable-assets')
                            ->with('error', trans('admin/hardware/message.isnot_responsible'));
            }
        }
        $recurrentWeeks = 0;
        
        // Let's check if this is a recurrent reservation        
        $recurrentCheckout = [];    // recurrent checkout array
        $recurrentCheckin = [];     // recurrent checkin array
        $checkoutWeeks = [];        // final recurrent checkout array without overlaping dates
        $checkinWeeks = [];         // final recurrent checkin array without overlaping dates
        
        // Is this a recurrent reservation
         if(e(Input::get('recurrent')) == '1') {
            $recurrentArray = array(array());



            $recurrentWeeks = (int)e(Input::get('weeks'));

            $checkoutDate = e(Input::get('checkout_at'));
            $checkinDate = e(Input::get('expected_checkin'));
            array_push($recurrentCheckout, date('Y-m-d H',strtotime($checkoutDate)));
            array_push($recurrentCheckin, date('Y-m-d H',strtotime($checkinDate)));
            
              for($i = 1; $i < $recurrentWeeks; $i++){                  
                  $days = ' + '.strval($i*7).' days';
              //  array_push($recurrentArray,date('Y-m-d H',strtotime(e(Input::get('checkout_at')))) , date('Y-m-d HH',strtotime(e(Input::get('expected_checkin')))));
               $newCheckoutDate = date('Y-m-d H',strtotime($checkoutDate. $days));
               $newCheckinDate = date('Y-m-d H',strtotime($checkinDate. $days));
                array_push($recurrentCheckout, $newCheckoutDate);
                array_push($recurrentCheckin, $newCheckinDate);
                
              }
            //  return redirect()->back() ->with('alert',recurrentArray[0,0]);
         }

        // double check if the checkout date is outside of any other reservation
        $requests =  DB::table('requested_assets')->where('asset_id',$assetId)->where('expected_checkout', '>=', date('Y-m-d'))->where('request_state', '<','2')->select('expected_checkout','expected_checkin')->get();
 
         $datas = "";


        for($i = 0; $i < $recurrentWeeks; $i++)
        {
            $checkOk = true;
            foreach($requests as &$request)
            {
                $datetime = strtotime($request->expected_checkout);
                $checkout = date('Y-m-d H',$datetime);
                $datetime = strtotime($request->expected_checkin);
                $checkin = date('Y-m-d H',$datetime);
                $checkout_test = strtotime(e(Input::get('checkout_at')));
                $checkout_now = date('Y-m-d H',$checkout_test);        
            
            if( $recurrentWeeks > 0) {
                $checkout_now = $recurrentCheckout[$i];
            }

            if ($checkout_now >= $checkout && $checkout_now <= $checkin)
                {
                    // return redirect()->back() ->with('alert',$checkin);
                    if( $recurrentWeeks > 0){
                        $checkOk = false;
                    } else {
                        return redirect()->route('requestable-assets')
                        ->with('error', trans('admin/hardware/message.dateOverlap'))->with('2');  
                    }
                }
            }
            if($recurrentWeeks > 0 && $checkOk) {
                array_push($checkoutWeeks, $recurrentCheckout[$i]);
                array_push($checkinWeeks, $recurrentCheckin[$i]);
                $datas = $datas .strval($recurrentCheckin[$i]);
             
            }
      }


        if (e(Input::get('checkout_at')) == null || e(Input::get('expected_checkin')) == null)
        {
            return redirect()->route('requestable-assets')
            ->with('error', trans('admin/hardware/message.no_dates'));  
        }

        if (e(Input::get('checkout_at')) == (e(Input::get('expected_checkin'))))
        {
            return redirect()->route('requestable-assets')
            ->with('error', trans('admin/hardware/message.equal_dates'));  

        }

        

                // -----------------------
        // GRIFU | Modification. Save data to the requested_assets table 
        $numReservations = count($checkoutWeeks);
        $userAuthorized = false;
        if($numReservations == 0) $numReservations = 1;
        for($i = 0; $i < $numReservations; $i++)
        {

            // Should optimze this (take all this one pass process to outside the for cycle)
            $requestedAsset->asset_id = $asset->id;
            $requestedAsset->checkout_requests_id = CheckoutRequest::all()->last()->id;
            $requestedAsset->user_id = $data['user_id'] = Auth::user()->id;
            $requestedAsset->notes = e(Input::get('note'));    
            $requestedAsset->created_at = $data['requested_date'] = date("Y-m-d H:i:s");

            if( $recurrentWeeks > 0) {
                $requestedAsset->expected_checkout =  $checkoutWeeks[$i];
                $requestedAsset->expected_checkin = $checkinWeeks[$i];
            } else {
                $requestedAsset->expected_checkout =  e(Input::get('checkout_at'));
                $requestedAsset->expected_checkin = e(Input::get('expected_checkin'));
            }


            $requestedAsset->responsible_id = e(Input::get('responsible'));

            $requestedAsset->save();
            
            if($recurrentWeeks > 0)
            {
                $requestedAsset = new RequestedAsset;
            }
            

            $data['item'] = $asset;
            $data['target'] =  Auth::user();
            $data['item_quantity'] = 1;


            $data['note'] = e(Input::get('note'));
            
            $user_responsible = e(Input::get('responsible'));
            $data['responsible'] = $user_responsible;
            if( $recurrentWeeks > 0) {
                $data['check_out'] =  $checkoutWeeks[$i];
                $data['check_in'] = $checkinWeeks[$i];
            } else {    
                $data['check_out'] = e(Input::get('checkout_at'));
                $data['check_in'] = e(Input::get('expected_checkin'));
            }
            $data['fieldset'] = e(Input::get('fieldset'));
            $data['request_id'] = $requestedAsset->id;

           
            $settings = Setting::getSettings();

            $logaction = new Actionlog();
            $logaction->item_id = $data['asset_id'] = $asset->id;
            $logaction->item_type = $data['item_type'] = Asset::class;
            $logaction->created_at = $data['requested_date'] = date("Y-m-d H:i:s");

            
            if ($user->location_id) {
                $logaction->location_id = $user->location_id;
            }
            $logaction->target_id = $data['user_id'] = Auth::user()->id;
            $logaction->target_type = User::class;
            if (!$asset->isRequestedBy(Auth::user())) {
                $userAuthorized = true;
                $user = User::find($user_responsible);
                $user->notify(new RequestAssetNotification($data));
            }
        
        }
            
        if (!$asset->isRequestedBy(Auth::user())) 
        {
            if(($recurrentWeeks > 0) && (count($recurrentCheckout) != count($checkoutWeeks))) {
                return redirect()->route('requestable-assets')->with('warning', trans('admin/hardware/message.requests.incomplete'));
            }
            if (e(Input::get('note')) != null)
            {
                return redirect()->route('requestable-assets')->with('success')->with('success', trans('admin/hardware/message.requests.success'));        
            } else {
                return redirect()->route('requestable-assets')->with('warning', trans('admin/hardware/message.requests.warning'));
            }
        }
    }


    public function store($assetId = null, $backto = null)
    {
        // Check if the asset exists
        if (is_null($asset = Asset::find($assetId))) {
            // Redirect to the asset management page with error
            return redirect()->route('hardware.index')->with('error', trans('admin/hardware/message.does_not_exist'));
        }

        $this->authorize('checkin', $asset);

        if ($asset->assignedType() == Asset::USER) {
            $user = $asset->assignedTo;
        }
        if (is_null($target = $asset->assignedTo)) {
            return redirect()->route('hardware.index')->with('error', trans('admin/hardware/message.checkin.already_checked_in'));
        }


        $asset->expected_checkin = null;
        $asset->last_checkout = null;
        $asset->assigned_to = null;
        $asset->assignedTo()->disassociate($asset);
        $asset->assigned_type = null;
        $asset->accepted = null;
        $asset->name = e($request->get('name'));

        if ($request->has('status_id')) {
            $asset->status_id =  e($request->get('status_id'));
        }

        $asset->location_id = $asset->rtd_location_id;

        if ($request->has('location_id')) {
            $asset->location_id =  e($request->get('location_id'));
        }



        // Was the asset updated?
        if ($asset->save()) {
            $logaction = $asset->logCheckin($target, e(request('note')));

            $data['log_id'] = $logaction->id;
            $data['first_name'] = get_class($target) == User::class ? $target->first_name : '';
            $data['last_name'] = get_class($target) == User::class ? $target->last_name : '';
            $data['item_name'] = $asset->present()->name();
            $data['responsible'] = $logaction->responsible;
            $data['checkout_at'] = $logaction->checkout_at;
            $data['checkin_date'] = $logaction->created_at;
            $data['fieldset'] = $logaction->fieldset;
            $data['item_tag'] = $asset->asset_tag;
            $data['item_serial'] = $asset->serial;
            $data['note'] = $logaction->note;
            $data['manufacturer_name'] = $asset->model->manufacturer->name;
            $data['model_name'] = $asset->model->name;
            $data['model_number'] = $asset->model->model_number;
            $data['destination']= "mail@gmail.com";
            $data['request_id'] = $requestedAsset->id;
            /*
            foreach($model->fieldset->fields AS $field) :
                if ($field->element=='listbox'){
                    $data[$item->$field->db_column_name()] = e(Input::get($item->$field->db_column_name()));
                }
    
    
            endforeach;
*/

            if ($backto=='user') {
                return redirect()->route("users.show", $user->id)->with('success', trans('admin/hardware/message.checkin.success'));
            }
            return redirect()->route("hardware.index")->with('success', trans('admin/hardware/message.checkin.success'));
        }
        // Redirect to the asset management page with error
        return redirect()->route("hardware.index")->with('error', trans('admin/hardware/message.checkin.error'));
    }





    public function getRequestedAssets()
    {
        return view('account/requested');
    }


    // Get the acceptance screen
    public function getAcceptAsset($logID = null)
    {

        $findlog = Actionlog::where('id', $logID)->first();

        if (!$findlog) {
            return redirect()->to('account/view-assets')->with('error', 'No matching record.');
        }

        if ($findlog->accepted_id!='') {
            return redirect()->to('account/view-assets')->with('error', trans('admin/users/message.error.asset_already_accepted'));
        }

        $user = Auth::user();
        

        // TODO - Fix this for non-assets
        if (($findlog->item_type==Asset::class) && ($user->id != $findlog->item->assigned_to)) {
            return redirect()->to('account/view-assets')->with('error', trans('admin/users/message.error.incorrect_user_accepted'));
        }


        $item = $findlog->item;

        // Check if the asset exists
        if (is_null($item)) {
            // Redirect to the asset management page
            return redirect()->to('account')->with('error', trans('admin/hardware/message.does_not_exist'));
        } elseif (!Company::isCurrentUserHasAccess($item)) {
            return redirect()->route('requestable-assets')->with('error', trans('general.insufficient_permissions'));
        } else {
            return view('account/accept-asset', compact('item'))->with('findlog', $findlog)->with('item', $item);
        }
    }

    // Save the acceptance
    public function postAcceptAsset(Request $request, $logID = null)
    {

        // Check if the asset exists
        if (is_null($findlog = Actionlog::where('id', $logID)->first())) {
            // Redirect to the asset management page
            return redirect()->to('account/view-assets')->with('error', trans('admin/hardware/message.does_not_exist'));
        }


        if ($findlog->accepted_id!='') {
            // Redirect to the asset management page
            return redirect()->to('account/view-assets')->with('error', trans('admin/users/message.error.asset_already_accepted'));
        }

        if (!Input::has('asset_acceptance')) {
            return redirect()->back()->with('error', trans('admin/users/message.error.accept_or_decline'));
        }

        $user = Auth::user();

        if (($findlog->item_type==Asset::class) && ($user->id != $findlog->item->assigned_to)) {
            return redirect()->to('account/view-assets')->with('error', trans('admin/users/message.error.incorrect_user_accepted'));
        }

        if ($request->has('signature_output')) {
            $path = config('app.private_uploads').'/signatures';
            $sig_filename = "siglog-".$findlog->id.'-'.date('Y-m-d-his').".png";
            $data_uri = e($request->get('signature_output'));
            $encoded_image = explode(",", $data_uri);
            $decoded_image = base64_decode($encoded_image[1]);
            file_put_contents($path."/".$sig_filename, $decoded_image);
        }


        $logaction = new Actionlog();

        if (Input::get('asset_acceptance')=='accepted') {
            $logaction_msg  = 'accepted';
            $accepted="accepted";
            $return_msg = trans('admin/users/message.accepted');
        } else {
            $logaction_msg = 'declined';
            $accepted="rejected";
            $return_msg = trans('admin/users/message.declined');
        }
            $logaction->item_id      = $findlog->item_id;
            $logaction->item_type    = $findlog->item_type;

        // Asset
        if (($findlog->item_id!='') && ($findlog->item_type==Asset::class)) {
            if (Input::get('asset_acceptance')!='accepted') {
                DB::table('assets')
                ->where('id', $findlog->item_id)
                ->update(array('assigned_to' => null));
            }
        }

        $logaction->target_id = $findlog->target_id;
        $logaction->target_type = User::class;
        $logaction->note = e(Input::get('note'));
        $logaction->updated_at = date("Y-m-d H:i:s");


        if (isset($sig_filename)) {
            $logaction->accept_signature = $sig_filename;
        }
        $log = $logaction->logaction($logaction_msg);

        $update_checkout = DB::table('action_logs')
        ->where('id', $findlog->id)
        ->update(array('accepted_id' => $logaction->id));

        if (($findlog->item_id!='') && ($findlog->item_type==Asset::class)) {
            $affected_asset = $logaction->item;
            $affected_asset->accepted = $accepted;
            $affected_asset->save();
        }

        if ($update_checkout) {
            return redirect()->to('account/view-assets')->with('success', $return_msg);

        } else {
            return redirect()->to('account/view-assets')->with('error', 'Something went wrong ');
        }
    }
}

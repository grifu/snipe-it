<?php

namespace App\Http\Controllers;

use App\Exceptions\CheckoutNotAllowed;
use App\Http\Controllers\CheckInOutRequest;
use App\Http\Requests\AssetCheckoutRequest;
use App\Models\Asset;
use App\Models\Location;
use App\Models\User;
use App\Models\RequestedAsset;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use DB; // GRIFU | Modificaiton

class AssetCheckoutController extends Controller
{
    use CheckInOutRequest;
    /**
    * Returns a view that presents a form to check an asset out to a
    * user.
    *
    * @author [A. Gianotto] [<snipe@snipe.net>]
    * @param int $assetId
    * @since [v1.0]
    * @return View
    */
    public function create($assetId)
    {
        // Check if the asset exists
        if (is_null($asset = Asset::find(e($assetId)))) {
            // Redirect to the asset management page with error
            return redirect()->route('hardware.index')->with('error', trans('admin/hardware/message.does_not_exist'));
        }

        $this->authorize('checkout', $asset);

        // Grifu | Modification. This should be called through model
        $requests =  DB::table('requested_assets')->where('asset_id',$assetId)->where('expected_checkout', '>=', date('Y-m-d'))->where('request_state', '<','2')->select('expected_checkout','expected_checkin')->get();

        if ($asset->availableForCheckout()) {
            return view('hardware/checkout', compact('asset'))->with('requests', $requests);    // Grifu | Modification. - Passing array with dates
        }
        return redirect()->route('hardware.index')->with('error', trans('admin/hardware/message.checkout.not_available'));

        // Get the dropdown of users and then pass it to the checkout view

    }

    use CheckInOutRequest;
    /**
    * Returns a view that presents a form to check an asset out to a
    * user.
    *
    * @author [A. Gianotto] [<snipe@snipe.net>]
    * @param int $assetId
    * @since [v1.0]
    * @return View
    */
    public function createRequest($assetId, $requestId)
    {

        // GRIFU: This should be changed to access the database through model
        // we grab the data from the request sending the dates, the asset, and user-id
        
        $requests =  DB::table('requested_assets')->where('id',$requestId)->select('expected_checkout','expected_checkin','request_state','user_id','asset_id','notes')->first();
        
        // Have to filter the notes field to avoid problems. 
        $notes = filter_var($requests->notes, FILTER_SANITIZE_STRING, FILTER_FLAG_STRIP_HIGH | FILTER_FLAG_STRIP_LOW);
        unset($requests->notes);


        // Check if the asset exists
        if (is_null($asset = Asset::find(e($assetId)))) {
            // Redirect to the asset management page with error
            return redirect()->route('hardware.index')->with('error', trans('admin/hardware/message.does_not_exist'));
        }

        $this->authorize('checkout', $asset);

        
        $extended = 0;  // this is just to ensure that we are not extending the checkout

        // passing User_id in a separate variable because the user_id inside $requests were returning a different value! Please verify this in the future 
        if ($asset->availableForCheckout()) {
            return view('hardware/checkoutRequest', compact('asset'))->with('requests', $requests)->with('extended',$extended)->with('userID',$requests->user_id)->with('notes',$notes);
        }
        return redirect()->route('hardware.index')->with('error', trans('admin/hardware/message.checkout.not_available'));

        // Get the dropdown of users and then pass it to the checkout view

    }


    use CheckInOutRequest;
    /**
    * Returns a view that presents a form to extend the checkout date
    *
    * @author [Grifu]
    * @param int $assetId
    * @since [v1.0]
    * @return View
    */
    public function extendRequest($assetId, $requestId)
    {

    
        
        // GRIFU | Modification: This should be changed to access the database through model
    //  Grab the user id from the assets
     $userID =  DB::table('assets')->where('id',$assetId)->select('assigned_to','expected_checkin','notes')->first();
        //  Grab all the requests for this asset to see if is blocked
     $requests =  DB::table('requested_assets')->where('asset_id',$assetId)->where('request_state', '<','2')->select('expected_checkout','expected_checkin')->get();

      // Have to filter the notes field to avoid problems. 
     $notes = filter_var($userID->notes, FILTER_SANITIZE_STRING, FILTER_FLAG_STRIP_HIGH | FILTER_FLAG_STRIP_LOW);
 


        // Check if the asset exists
        if (is_null($asset = Asset::find(e($assetId)))) {
            // Redirect to the asset management page with error
            return redirect()->route('hardware.index')->with('error', trans('admin/hardware/message.does_not_exist'));
        }

        $this->authorize('checkout', $asset);
        $extended = 1;  // let's pass the extension to the view

        // I have to check if there is atleast one day for extension by checking if the next checkout date is one day after
        // compare the next checkout date with today by subtracting the date
      

        if ($asset->checkedOutToUser()) {
          //  return view('hardware/requestout', compact('asset'))->with('store', $store);

          // tem de ser este
            return view('hardware/checkoutRequest', compact('asset'))->with('requests', $requests)->with('extended',$extended)->with('userID',$userID->assigned_to)->with('notes',$notes);
        }
        return redirect()->route('hardware.index')->with('error', trans('admin/hardware/message.checkout.not_available'));

        // Get the dropdown of users and then pass it to the checkout view

    }


    /**
     * Validate and process the form data to extend the check out.
     *
     * @author [Grifu]
     * @param AssetCheckoutRequest $request
     * @param int $assetId
     * @return Redirect
     * @since [v1.0]
     */
    public function storeExtension(AssetCheckoutRequest $request, $assetId, $requestId = 0)
    {
        echo 'alert("message successfully sent")';
        echo 'mensagem' . $assetId . ' espaco ';

        try {
            // Check if the asset exists
            if (!$asset = Asset::find($assetId)) {
                return redirect()->route('hardware.index')->with('error', trans('admin/hardware/message.does_not_exist'));
            } elseif (!$asset->availableForCheckout()) {
              //  return redirect()->route('hardware.index')->with('error', trans('admin/hardware/message.checkout.not_available'));
            }
        

            $this->authorize('checkout', $asset);
            $admin = Auth::user();

            $target = $this->determineCheckoutTarget($asset);
            if ($asset->is($target)) {
                throw new CheckoutNotAllowed('You cannot check an asset out to itself.');
            }
            $asset = $this->updateAssetLocation($asset, $target);

            $checkout_at = date("Y-m-d H:i:s");
            if (($request->has('checkout_at')) && ($request->get('checkout_at')!= date("Y-m-d"))) {
                $checkout_at = $request->get('checkout_at');
            }

            $expected_checkin = '';
            if ($request->has('expected_checkin')) {
                $expected_checkin = $request->get('expected_checkin');
            }

            if ($asset->checkOut($target, $admin, $checkout_at, $expected_checkin, e($request->get('note')), $request->get('name'))) {
                $requestedAsset = new RequestedAsset;
                $requestedAsset->find($requestId);


                $requestedAsset->where('id',$requestId)->update(array('request_state' => '4'));
                return redirect()->route("hardware.index")->with('success', trans('admin/hardware/message.checkout.success'));
            }

            // Redirect to the asset management page with error
            return redirect()->to("hardware/$assetId/checkout")->with('error', trans('admin/hardware/message.checkout.error'))->withErrors($asset->getErrors());
        } catch (ModelNotFoundException $e) {
            return redirect()->back()->with('error', trans('admin/hardware/message.checkout.error'))->withErrors($asset->getErrors());
        } catch (CheckoutNotAllowed $e) {
            return redirect()->back()->with('error', $e->getMessage());
        }
    }


    /**
     * Validate and process the form data to check out an asset to a user.
     *
     * @author [A. Gianotto] [<snipe@snipe.net>]
     * @param AssetCheckoutRequest $request
     * @param int $assetId
     * @return Redirect
     * @since [v1.0]
     */
    public function store(AssetCheckoutRequest $request, $assetId, $requestId = 0)
    {

    

        try {
            // Check if the asset exists
            if (!$asset = Asset::find($assetId)) {
                return redirect()->route('hardware.index')->with('error', trans('admin/hardware/message.does_not_exist'));
            } elseif (!$asset->availableForCheckout()) {
                return redirect()->route('hardware.index')->with('error', trans('admin/hardware/message.checkout.not_available'));
            }
        

            $this->authorize('checkout', $asset);
            $admin = Auth::user();

            $target = $this->determineCheckoutTarget($asset);
            if ($asset->is($target)) {
                throw new CheckoutNotAllowed('You cannot check an asset out to itself.');
            }
            $asset = $this->updateAssetLocation($asset, $target);

            $checkout_at = date("Y-m-d H:i:s");
            if (($request->has('checkout_at')) && ($request->get('checkout_at')!= date("Y-m-d"))) {
                $checkout_at = $request->get('checkout_at');
            }

            $expected_checkin = '';
            if ($request->has('expected_checkin')) {
                $expected_checkin = $request->get('expected_checkin');
            }

            if ($asset->checkOut($target, $admin, $checkout_at, $expected_checkin, e($request->get('note')), $request->get('name'))) {
                $requestedAsset = new RequestedAsset;
                $requestedAsset->find($requestId);


                $requestedAsset->where('id',$requestId)->update(array('request_state' => '4'));
                return redirect()->route("hardware.index")->with('success', trans('admin/hardware/message.checkout.success'));
            }

            // Redirect to the asset management page with error
            return redirect()->to("hardware/$assetId/checkout")->with('error', trans('admin/hardware/message.checkout.error'))->withErrors($asset->getErrors());
        } catch (ModelNotFoundException $e) {
            return redirect()->back()->with('error', trans('admin/hardware/message.checkout.error'))->withErrors($asset->getErrors());
        } catch (CheckoutNotAllowed $e) {
            return redirect()->back()->with('error', $e->getMessage());
        }
    }

}

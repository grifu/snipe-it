<?php

namespace App\Models;

use App\Models\CheckoutRequest;
//use App\Models\CheckoutExtend; // Grifu Fev2021 building the extend model
use App\Models\RequestedAsset;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

// $asset->requests
// $asset->isRequestedBy($user)
// $asset->whereRequestedBy($user)
trait Requestable
{

    public function requests()
    {
        return $this->morphMany(CheckoutRequest::class, 'requestable');
    }

    // GRIFU | Modification
    public function assetRequests()
    {
        return $this->morphMany(RequestedAsset::class, 'checkout_requests');
    }

    public function isRequestedBy(User $user)
    {
        return $this->requests->where('canceled_at', NULL)->where('user_id', $user->id)->first();
    }

    public function scopeRequestedBy($query, User $user)
    {
        return $query->whereHas('requests', function ($query) use ($user) {
            $query->where('user_id', $user->id);
        });
    }

    public function request($qty = 1)
    {
        $this->requests()->save(
            new CheckoutRequest(['user_id' => Auth::id(), 'qty' => $qty])
        );
    }

    public function deleteRequest()
    {
        $this->requests()->where('user_id', Auth::id())->delete();
    }

    public function cancelRequest()
    {
        $this->requests()->where('user_id', Auth::id())->update(['canceled_at' => \Carbon\Carbon::now()]);

        // GRIFU | Modification. Cancel request 
        //$this->assetRequests()->where('user_id', Auth::id())->update(['request_state' => '3']);
    }
}

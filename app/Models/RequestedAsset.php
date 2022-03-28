<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class RequestedAsset extends Model
{
 
    protected $table = 'requested_assets';

    public function checkoutRequests()
    {
        return $this->belongsTo('app\Models\CheckoutRequest','checkout_requests_id','id');
    }


    public function responsible()
    {
        return $this->belongsTo(User::class, 'responsible_id', 'id');
    }


    public function requestingResponsible()
    {
        return $this->responsible()->first();
    }
    
 
/*

    public function checkoutRequests2()
    {
        return $this->hasOne('checkout_requests','id', 'checkout_request_id');

    }



    public function requestedItem()
    {
        return $this->morphTo('requestable');
    }

    
    public function itemRequested() // Workaround for laravel polymorphic issue that's not being solved :(
    {
        return $this->requestedItem()->first();
    }

    public function itemType()
    {
        return snake_case(class_basename($this->requestable_type));
    }

    public function location()
    {
        return $this->itemRequested()->location;
    }

    public function name()
    {
        if ($this->itemType() == "asset") {
            return $this->itemRequested()->present()->name();
        }
        return $this->itemRequested()->name;

    }
    */
}

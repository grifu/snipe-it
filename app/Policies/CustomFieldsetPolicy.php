<?php

namespace App\Policies;

use App\Policies\SnipePermissionsPolicy;

class CustomFieldsetPolicy extends SnipePermissionsPolicy
{
    protected function columnName()
    {
        /**
         * Proxy the authorization for custom fieldsets down to custom fields.
         * This allows us to use the existing permissions in use and have more 
         * semantically correct authorization checks for custom fieldsets.
         *
         * See: https://github.com/snipe/snipe-it/pull/5795
         */
        return 'customfields';
    }	
}

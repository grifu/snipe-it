<?php

namespace App\Policies;

use App\Policies\SnipePermissionsPolicy;

class FlorbPolicy extends SnipePermissionsPolicy
{
    protected function columnName()
    {
        return 'florbs';
    }
}
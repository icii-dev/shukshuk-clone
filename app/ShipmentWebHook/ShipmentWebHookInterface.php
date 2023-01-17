<?php

namespace App\ShipmentWebHook;

interface ShipmentWebHookInterface
{
    public function handle($payload);
}

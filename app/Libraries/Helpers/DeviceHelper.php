<?php

namespace App\Libraries\Helpers;


use App\Models\Device;

class DeviceHelper
{
    /**
     * @var Device $device
     */
    public static Device $device;

    /**
     * Set Device
     * @param Device $device
     */
    public static function setDevice(Device $device): void
    {
        self::$device = $device;
    }

    /**
     * Get Device
     * @return Device
     */
    public static function getDevice(): Device
    {
        return self::$device;
    }
}
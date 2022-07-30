<?php

namespace App\Http\Middleware;

use App\Enum\MessagesEnum;
use App\Http\Resources\DeviceResource;
use App\Libraries\Helpers\DeviceHelper;
use App\Models\Device;
use Closure;
use Illuminate\Http\Request;

class ClientToken
{
    /**
     * Handle an incoming request.
     *
     * @param Request $request
     * @param Closure $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next): mixed
    {
        $data = $request->all();
        $device = Device::where('token', $data['client-token'])->first();
        if (empty($device)) {
            return DeviceResource::handle(MessagesEnum::DEVICE_CLIENT_NOT_FOUND);
        }
        DeviceHelper::setDevice($device);
        return $next($request);
    }
}
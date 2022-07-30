<?php

namespace App\Http\Controllers;

use App\Enum\MessagesEnum;
use App\Http\Requests\StoreDeviceRequest;
use App\Http\Requests\UpdateDeviceRequest;
use App\Http\Resources\DeviceResource;
use App\Models\Device;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Illuminate\Http\Response;

/**
 * App Controller
 */
class DeviceController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     */
    public function list(): AnonymousResourceCollection
    {
        return DeviceResource::collection(Device::paginate(100));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param StoreDeviceRequest $request
     * @return JsonResponse
     */
    public function store(StoreDeviceRequest $request): JsonResponse
    {
        $data = $request->validated();
        $data['token'] = Device::hash();
        $device = Device::firstOrCreate(['uid'=>$request->uid,'app_id'=>$request->app_id],$data);
        return DeviceResource::result($device);
    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     * @return JsonResponse|DeviceResource
     */
    public function show(int $id): JsonResponse|DeviceResource
    {
        $device = Device::find($id);
        if (empty($device)) {
            return DeviceResource::handle(MessagesEnum::DEVICE_NOT_FOUND);
        }
        return new DeviceResource($device);
    }

    /**
     * Update
     * @param UpdateDeviceRequest $request
     * @param int $id
     * @return JsonResponse|DeviceResource
     */
    public function update(UpdateDeviceRequest $request, int $id): JsonResponse|DeviceResource
    {
        $device = Device::find($id);
        if (empty($device)) {
            return DeviceResource::handle(MessagesEnum::DEVICE_NOT_FOUND);
        }
        $data = $request->validated();
        if (empty($data)) {
            return DeviceResource::handle(MessagesEnum::DEVICE_NOT_CHANGED);
        }
        if ($data['uid'] != $device->uid || $data['app_id'] != $device->app_id) {
            $isDuplicate = Device::where('uid', $data['uid'])->where('app_id', $data['app_id'])->exists();
            if ($isDuplicate) {
                return DeviceResource::handle(MessagesEnum::DEVICE_DUPLICATE);
            }
        }
        $data['token'] = Device::hash();
        if ($device->update($data)) {
            return DeviceResource::result($device);
        }
        return DeviceResource::handle(MessagesEnum::DEVICE_SOMETHING_WENT_WRONG);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return JsonResponse
     */
    public function destroy(int $id): JsonResponse
    {
        $device = Device::find($id);
        if (empty($device)) {
            return DeviceResource::handle(MessagesEnum::DEVICE_NOT_FOUND);
        }
        if ($device->delete()) {
            return DeviceResource::success(MessagesEnum::DEVICE_SUCCESS_DELETE);
        }
        return DeviceResource::handle(MessagesEnum::DEVICE_NOT_FOUND);
    }
}

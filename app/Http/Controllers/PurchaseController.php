<?php

namespace App\Http\Controllers;

use App\Enum\MessagesEnum;
use App\Http\Requests\ProcessPurchaseRequest;
use App\Http\Resources\PurchaseResource;
use App\Libraries\Helpers\DeviceHelper;
use App\Models\Purchase;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

/**
 * App Controller
 */
class PurchaseController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     */
    public function list(): AnonymousResourceCollection
    {
        return PurchaseResource::collection(Purchase::paginate(100));
    }

    /**
     * Process
     * @param ProcessPurchaseRequest $request
     * @return JsonResponse
     */
    public function process(ProcessPurchaseRequest $request): JsonResponse
    {
        $data = $request->validated();
        $receipt = $data['receipt'];

        $device = DeviceHelper::getDevice();

        $verify = Purchase::verify($device->os, $receipt);
        if (!$verify['status']) {
            return PurchaseResource::handle(MessagesEnum::PURCHASE_NOT_VERIFY);
        }
        Purchase::updateOrCreate(['receipt' => $receipt], [
            'device_id' => $device->id,
            'receipt' => $receipt,
            'expire_time' => $verify['expire_time'],
            'status' => $verify['status']
        ]);
        return PurchaseResource::result(Purchase::where('receipt', $receipt)->first());
    }

    /**
     * Check Subscription
     * @return JsonResponse
     */
    public function check(): JsonResponse
    {
        $device = DeviceHelper::getDevice();
        $purchase = $device->purchase()->first();
        if (empty($purchase)) {
            return PurchaseResource::handle(MessagesEnum::PURCHASE_NOT_FOUND);
        }
        return PurchaseResource::result($purchase);
    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     * @return JsonResponse|PurchaseResource
     */
    public function show(int $id): JsonResponse|PurchaseResource
    {
        $purchase = Purchase::find($id);
        if (empty($purchase)) {
            return PurchaseResource::handle(MessagesEnum::PURCHASE_NOT_FOUND);
        }
        return new PurchaseResource($purchase);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return JsonResponse
     */
    public function destroy(int $id): JsonResponse
    {
        $purchase = Purchase::find($id);
        if (empty($purchase)) {
            return Purchase::handle(MessagesEnum::PURCHASE_NOT_FOUND);
        }
        if ($purchase->delete()) {
            return PurchaseResource::success(MessagesEnum::PURCHASE_SUCCESS_DELETE);
        }
        return PurchaseResource::handle(MessagesEnum::PURCHASE_SOMETHING_WENT_WRONG);
    }
}

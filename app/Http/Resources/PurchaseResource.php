<?php

namespace App\Http\Resources;

use App\Enum\PurchaseStatusEnum;
use Illuminate\Http\Request;

/**
 * @property int $id
 * @property int $device_id
 * @property string $receipt
 * @property mixed $expire_time
 * @property string $status
 */
class PurchaseResource extends BasicResource
{

    /**
     * Transform the resource collection into an array.
     *
     * @param Request $request
     * @return array
     */
    public function toArray($request): array
    {
        return [
            "device_id" => $this->id,
            "receipt" => $this->receipt,
            "expire_time" => $this->expire_time,
            "status" => PurchaseStatusEnum::purchaseStatusHuman($this->status),
        ];
    }

}

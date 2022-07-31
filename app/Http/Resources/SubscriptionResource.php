<?php

namespace App\Http\Resources;

use App\Enum\PurchaseStatusEnum;
use App\Models\Purchase;
use Illuminate\Http\Request;

/**
 * @property int $uid
 * @property string $os
 * @property Purchase $purchase
 * @property Purchase $subscription
 */
class SubscriptionResource extends BasicResource
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
            'device' => $this->uid,
            'platform' => $this->os,
            'status' => PurchaseStatusEnum::purchaseStatusHuman($this->subscription->status ?? 0),
        ];
    }
}

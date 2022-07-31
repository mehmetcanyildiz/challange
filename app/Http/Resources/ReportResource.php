<?php

namespace App\Http\Resources;

use App\Models\Purchase;
use App\Models\Device;
use Illuminate\Http\Request;

/**
 * @property int $id
 * @property string $name
 * @property string $callback
 * @property Device $device
 */
class ReportResource extends BasicResource
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
            "id" => $this->id,
            "name" => $this->name,
            "callback" => $this->callback,
            "devices" => [
                'ios' => $this->device->where('os', 'ios')->count(),
                'android' => $this->device->where('os', 'android')->count(),
                'total' => $this->device->count()
            ],
            "subscription" => SubscriptionResource::collection($this->device)
        ];
    }
}

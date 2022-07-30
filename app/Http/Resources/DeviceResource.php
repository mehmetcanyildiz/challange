<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;

/**
 * @property int $id
 * @property int $app_id
 * @property int $uid
 * @property string $language
 * @property string $os
 * @property string $token
 */
class DeviceResource extends BasicResource
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
            "app_id" => $this->app_id,
            "uid" => $this->uid,
            "language" => $this->language,
            "os" => $this->os,
            "token" => $this->token,
        ];
    }
}

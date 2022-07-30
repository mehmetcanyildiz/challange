<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;

/**
 * @property int $id
 * @property string $name
 * @property string $callback
 */
class AppResource extends BasicResource
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
            "callback" => $this->callback
        ];
    }
}

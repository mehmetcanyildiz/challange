<?php

namespace App\Http\Requests;

/**
 * @property int $app_id
 * @property int $uid
 * @property string $language
 * @property string $os
 * @property string $token
 */
class StoreDeviceRequest extends BaseRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules(): array
    {
        return [
            'app_id' => 'numeric|required|digits_between:1,20',
            'uid' => 'numeric|required|digits_between:6,20',
            'language' => 'string|required|max:20',
            'os' => 'string|required|in:ios,android',
        ];
    }
}

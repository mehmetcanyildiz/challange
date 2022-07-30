<?php

namespace App\Http\Requests;

class UpdateDeviceRequest extends BaseRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules(): array
    {
        return [
            'app_id' => 'numeric|digits_between:1,20',
            'uid' => 'numeric|digits_between:6,20',
            'language' => 'string|max:20',
            'os' => 'string|in:ios,android',
        ];
    }
}

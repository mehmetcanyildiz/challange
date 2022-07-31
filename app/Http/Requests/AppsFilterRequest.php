<?php

namespace App\Http\Requests;

class AppsFilterRequest extends BaseRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules(): array
    {
        return [
            'name' => 'string',
            'callback' => 'string',
        ];
    }
}

<?php

namespace App\Http\Requests;

class StoreAppRequest extends BaseRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules(): array
    {
        return [
            'name' => 'string|required|max:100',
            'callback' => 'string|required|max:180',
        ];
    }
}

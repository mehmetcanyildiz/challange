<?php

namespace App\Http\Requests;

class CheckPurchaseRequest extends BaseRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules(): array
    {
        return [
            'client-token' => 'string|required',
        ];
    }
}

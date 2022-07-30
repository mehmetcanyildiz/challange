<?php

namespace App\Http\Requests;

class ProcessPurchaseRequest extends BaseRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules(): array
    {
        return [
            'receipt' => 'string|required|max:50',
            'client-token' => 'string|required',
        ];
    }
}

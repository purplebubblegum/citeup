<?php

namespace App\Modules\Api\V1\Requests\Activities;

use Illuminate\Foundation\Http\FormRequest;

class ActivityShowRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }
}

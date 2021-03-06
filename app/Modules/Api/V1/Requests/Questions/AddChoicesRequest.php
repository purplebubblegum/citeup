<?php

namespace App\Modules\Api\V1\Requests\Questions;

use Illuminate\Foundation\Http\FormRequest;

class AddChoicesRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        $user = $this->user();

        return $user->isAdmin() || $user->hasKey('post-questions-choices');
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'choices' => 'required|array',
            'choices.*.content' => 'required|string',
            'choices.*.picture' => 'string|max:191',
        ];
    }
}

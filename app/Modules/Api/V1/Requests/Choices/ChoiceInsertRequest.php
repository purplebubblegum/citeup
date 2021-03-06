<?php

namespace App\Modules\Api\V1\Requests\Choices;

use App\Modules\Models\Choice;
use Illuminate\Foundation\Http\FormRequest;

class ChoiceInsertRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        $user = $this->user();

        return $user->isAdmin() || $user->hasKey('post-choices');
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'question' => 'required|int|exists:questions,id',
            'content' => 'required|string',
            'picture' => 'string|max:191',
        ];
    }
}

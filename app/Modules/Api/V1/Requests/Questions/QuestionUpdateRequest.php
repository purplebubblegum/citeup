<?php

namespace App\Modules\Api\V1\Requests\Questions;

use Illuminate\Foundation\Http\FormRequest;

class QuestionUpdateRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        $user = $this->user();

        return $user->isAdmin() || $user->hasKey('put-questions');
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'content' => 'string',
            'picture' => 'string|max:191|nullable',
            'choices' => 'array',
            'choices.*.id' => 'sometimes|required|integer|exists:choices,id',
            'choices.*.content' => 'string',
        ];
    }
}

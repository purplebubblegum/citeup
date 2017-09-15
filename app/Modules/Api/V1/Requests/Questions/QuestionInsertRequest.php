<?php

namespace App\Modules\Api\V1\Requests\Questions;

use App\Modules\Models\Question;
use Illuminate\Foundation\Http\FormRequest;

class QuestionInsertRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        $user = $this->user();

        return $user->isAdmin() || $user->hasKey('post-questions');
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'content' => 'required|string',
            'choices' => 'array',
            'choices.*.content' => 'string',
        ];
    }
}

<?php

namespace App\Modules\Api\V1\Requests\Submissions;

use App\Modules\Models\Submission;
use Illuminate\Foundation\Http\FormRequest;

class SubmissionInsertRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        $user = $this->user();

        return $user->isAdmin() || $user->hasKey('post-submissions') || $user->isEntrant();
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'entry' => 'required|int|exists:entries,id',
            'description' => 'required|string',
            'picture' => 'required|string|max:191',
        ];
    }
}

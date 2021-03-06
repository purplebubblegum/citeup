<?php

namespace App\Modules\Api\V1\Requests\Submissions;

use App\Modules\Models\Submission;
use App\Modules\Electrons\Shared\Requests\ApiIndexRequest;

class SubmissionIndexRequest extends ApiIndexRequest
{
    /**
     * The main model for the request.
     *
     * @var Submission
     */
    protected $model = Submission::class;

    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        $user = $this->user();

        $entry = strpos($this->url(), 'entries/') !== false ?
            $this->route('entry')->id :
            $this->input('entry', null);

        // dd($this->input('entry'), $user->entry->id);

        return $user->isAdmin() || $user->hasKey('get-submissions') || 
            ($user->isEntrant() && $user->entry->id == $entry);
    }

    /**
     * Returns additional rules aside from the query string rules.
     *
     * @return array
     */
    protected function additional()
    {
        return [
            'entry' => 'int|exists:entries,id',
        ];
    }
}

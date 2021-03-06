<?php

namespace App\Modules\Api\V1\Requests\Documents;

use App\User;
use App\Modules\Models\Document;
use App\Modules\Electrons\Shared\Requests\ApiIndexRequest;

class DocumentIndexRequest extends ApiIndexRequest
{
    /**
     * The main model for the request.
     *
     * @var Document
     */
    protected $model = Document::class;

    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        $user = $this->user();

        $target = $this->input('user', null);

        return $user->isAdmin() || $user->hasKey('get-documents') || 
            ($user->isEntrant() && $user->entry->id === User::find($target)->entry->id);
    }

    /**
     * Returns additional rules aside from the query string rules.
     *
     * @return array
     */
    protected function additional()
    {
        return [
            'user' => 'int|exists:users,id',
            'entry' => 'int|exists:entries,id',
            'type' => 'int|between:0,9',
        ];
    }
}

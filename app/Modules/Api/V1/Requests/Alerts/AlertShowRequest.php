<?php

namespace App\Modules\Api\V1\Requests\Alerts;

use Illuminate\Foundation\Http\FormRequest;

class AlertShowRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        $user = $this->user();

        $alert = $this->route('alert');

        return $user->isAdmin() || $user->hasKey('view-alerts') || 
            $alert->users->search(function ($item, $key) use ($user) {
                return $item->id === $user->id;
            }) !== false;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            //
        ];
    }
}

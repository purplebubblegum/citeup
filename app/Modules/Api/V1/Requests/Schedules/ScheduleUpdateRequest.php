<?php

namespace App\Modules\Api\V1\Requests\Schedules;

use Illuminate\Foundation\Http\FormRequest;

class ScheduleUpdateRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return $this->user()->can('put', $this->route('schedule'));
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'description' => 'string|max:191',
            'held_at' => 'date_format:Y-m-d H:i:s',
        ];
    }
}

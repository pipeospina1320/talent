<?php

namespace App\Http\Requests;

use App\Enums\MorphEntities;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreProgramParticipantRequest extends FormRequest
{

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'program_id' => 'required|integer|exists:programs,id',
            'entity_id' => 'required|integer',
            'entity_type' => ['required', Rule::enum(MorphEntities::class)],
        ];
    }
}

<?php

namespace App\Http\Requests\Banner;

use Illuminate\Foundation\Http\FormRequest;
use App\Model\Banner\Banner;
use Illuminate\Validation\Rule;
class EditRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'name' => 'required|string',
            'limit' => 'required|integer',
            'url' => 'required|url',

        ];
    }
}

<?php

namespace App\Http\Requests;

use App\Models\Page;
use Gate;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Response;

class StorePageRequest extends FormRequest
{
    public function authorize()
    {
        return Gate::allows('page_create');
    }

    public function rules()
    {
        return [
            'title' => [
                'string',
                'required',
                function ($attribute, $value, $fail) {
                    if (strpos($value, '_') !== false) {
                        $fail('O campo de título não pode conter underline(_)');
                    }
                },
            ],
            'content' => [
                'required',
            ],
            'photos' => [
                'array',
            ],
        ];
    }
}

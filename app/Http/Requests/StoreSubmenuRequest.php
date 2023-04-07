<?php

namespace App\Http\Requests;

use App\Models\Submenu;
use Gate;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Response;

class StoreSubmenuRequest extends FormRequest
{
    public function authorize()
    {
        return Gate::allows('submenu_create');
    }

    public function rules()
    {
        return [
            'title' => [
                'string',
                'required',
            ],
            'link_type' => [
                'required',
            ],
            'url' => [
                'string',
                'nullable',
            ],
        ];
    }
}

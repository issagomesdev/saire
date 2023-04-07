<?php

namespace App\Http\Requests;

use App\Models\Menu;
use Gate;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Response;

class UpdateMenuRequest extends FormRequest
{
    public function authorize()
    {
        return Gate::allows('menu_edit');
    }

    public function rules()
    {
        return [
            'title' => [
                'string',
                'required',
                'unique:menus,title,' . request()->route('menu')->id,
            ],
            'link_type' => [
                'required',
            ],
            'submenuses.*' => [
                'integer',
            ],
            'submenuses' => [
                'array',
            ],
            'url' => [
                'string',
                'nullable',
            ],
        ];
    }
}

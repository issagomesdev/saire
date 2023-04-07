<?php

namespace App\Http\Requests;

use App\Models\Submenu;
use Gate;
use Illuminate\Foundation\Http\FormRequest;
use Symfony\Component\HttpFoundation\Response;

class MassDestroySubmenuRequest extends FormRequest
{
    public function authorize()
    {
        abort_if(Gate::denies('submenu_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return true;
    }

    public function rules()
    {
        return [
            'ids'   => 'required|array',
            'ids.*' => 'exists:submenus,id',
        ];
    }
}

@extends('layouts.admin')
@section('content')

<div class="card">
    <div class="card-header">
        {{ trans('global.show') }} {{ trans('cruds.submenu.title') }}
    </div>

    <div class="card-body">
        <div class="form-group">
            <div class="form-group">
                <a class="btn btn-default" href="{{ route('admin.submenus.index') }}">
                    {{ trans('global.back_to_list') }}
                </a>
            </div>
            <table class="table table-bordered table-striped">
                <tbody>
                    <tr>
                        <th>
                            {{ trans('cruds.submenu.fields.id') }}
                        </th>
                        <td>
                            {{ $submenu->id }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.submenu.fields.title') }}
                        </th>
                        <td>
                            {{ $submenu->title }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.submenu.fields.link_type') }}
                        </th>
                        <td>
                            {{ App\Models\Submenu::LINK_TYPE_RADIO[$submenu->link_type] ?? '' }}
                        </td>
                    </tr>
                    @if($submenu->link_type == 0)
                    <tr>
                        <th>
                            {{ trans('cruds.submenu.fields.page') }}
                        </th>
                        <td>
                            {{ $submenu->page->title ?? '' }}
                        </td>
                    </tr>
                    @endif
                    @if($submenu->link_type == 1)
                    <tr>
                        <th>
                            {{ trans('cruds.submenu.fields.url') }}
                        </th>
                        <td>
                            {{ $submenu->url }}
                        </td>
                    </tr>
                    @endif
                    <tr>
                        <th>
                            {{ trans('cruds.submenu.fields.created_at') }}
                        </th>
                        <td>
                            {{ $submenu->created_at }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.submenu.fields.updated_at') }}
                        </th>
                        <td>
                            {{ $submenu->updated_at }}
                        </td>
                    </tr>
                </tbody>
            </table>
            <div class="form-group">
                <a class="btn btn-default" href="{{ route('admin.submenus.index') }}">
                    {{ trans('global.back_to_list') }}
                </a>
            </div>
        </div>
    </div>
</div>



@endsection
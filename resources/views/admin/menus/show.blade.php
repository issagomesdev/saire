@extends('layouts.admin')
@section('content')

<div class="card">
    <div class="card-header">
        {{ trans('global.show') }} {{ trans('cruds.menu.title') }}
    </div>

    <div class="card-body">
        <div class="form-group">
            <div class="form-group">
                <a class="btn btn-default" href="{{ route('admin.menus.index') }}">
                    {{ trans('global.back_to_list') }}
                </a>
            </div>
            <table class="table table-bordered table-striped">
                <tbody>
                    <tr>
                        <th>
                            {{ trans('cruds.menu.fields.id') }}
                        </th>
                        <td>
                            {{ $menu->id }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.menu.fields.title') }}
                        </th>
                        <td>
                            {{ $menu->title }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.menu.fields.link_type') }}
                        </th>
                        <td>
                            {{ App\Models\Menu::LINK_TYPE_RADIO[$menu->link_type] ?? '' }}
                        </td>
                    </tr>
                    @if($menu->link_type == 0)
                    <tr>
                        <th>
                            {{ trans('cruds.menu.fields.submenus') }}
                        </th>
                        <td>
                            @foreach($menu->submenuses as $key => $submenus)
                                <span class="label label-info">{{ $submenus->title }}</span>
                            @endforeach
                        </td>
                    </tr>
                    @endif
                    @if($menu->link_type == 1)
                    <tr>
                        <th>
                            {{ trans('cruds.menu.fields.page') }}
                        </th>
                        <td>
                            {{ $menu->page->title ?? '' }}
                        </td>
                    </tr>
                    @endif
                    @if($menu->link_type == 2)
                    <tr>
                        <th>
                            {{ trans('cruds.menu.fields.url') }}
                        </th>
                        <td>
                            {{ $menu->url }}
                        </td>
                    </tr>
                    @endif
                    <tr>
                        <th>
                            {{ trans('cruds.menu.fields.created_at') }}
                        </th>
                        <td>
                            {{ $menu->created_at }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.menu.fields.updated_at') }}
                        </th>
                        <td>
                            {{ $menu->updated_at }}
                        </td>
                    </tr>
                </tbody>
            </table>
            <div class="form-group">
                <a class="btn btn-default" href="{{ route('admin.menus.index') }}">
                    {{ trans('global.back_to_list') }}
                </a>
            </div>
        </div>
    </div>
</div>



@endsection
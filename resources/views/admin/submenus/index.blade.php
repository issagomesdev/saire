@extends('layouts.admin')
@section('content')
@can('submenu_create')
    <div style="margin-bottom: 10px;" class="row">
        <div class="col-lg-12">
            <a class="btn btn-success" href="{{ route('admin.submenus.create') }}">
                {{ trans('global.add') }} {{ trans('cruds.submenu.title_singular') }}
            </a>
        </div>
    </div>
@endcan
<div class="card">
    <div class="card-header">
        {{ trans('cruds.submenu.title_singular') }} {{ trans('global.list') }}
    </div>

    <div class="card-body">
        <table class=" table table-bordered table-striped table-hover ajaxTable datatable datatable-Submenu">
            <thead>
                <tr>
                    <th width="10">

                    </th>
                    <th>
                        {{ trans('cruds.submenu.fields.id') }}
                    </th>
                    <th>
                        {{ trans('cruds.submenu.fields.title') }}
                    </th>
                    <th>
                        {{ trans('cruds.submenu.fields.link_type') }}
                    </th>
                    <th>
                        {{ trans('cruds.submenu.fields.created_at') }}
                    </th>
                    <th>
                        &nbsp;
                    </th>
                </tr>
                <tr>
                    <td>
                    </td>
                    <td>
                        <input class="search" type="text" placeholder="{{ trans('global.search') }}">
                    </td>
                    <td>
                        <input class="search" type="text" placeholder="{{ trans('global.search') }}">
                    </td>
                    <td>
                        <select class="search" strict="true">
                            <option value>{{ trans('global.all') }}</option>
                            @foreach(App\Models\Submenu::LINK_TYPE_RADIO as $key => $item)
                                <option value="{{ $key }}">{{ $item }}</option>
                            @endforeach
                        </select>
                    </td>
                    <td>
                        <input class="search" type="text" placeholder="{{ trans('global.search') }}">
                    </td>
                    <td>
                    </td>
                </tr>
            </thead>
        </table>
    </div>
</div>



@endsection
@section('scripts')
@parent
<script>
    $(function () {
        initAdminDataTable('.datatable-Submenu', {
            ajax: "{{ route('admin.submenus.index') }}",
            columns: [
                { data: 'placeholder', name: 'placeholder', orderable: false, searchable: false },
                { data: 'id', name: 'id' },
                { data: 'title', name: 'title' },
                { data: 'link_type', name: 'link_type' },
                { data: 'created_at', name: 'created_at' },
                { data: 'actions', name: '{{ trans('global.actions') }}', orderable: false, searchable: false },
            ],
            order: [[1, 'desc']],
@can('submenu_delete')
            deleteRoute: "{{ route('admin.submenus.massDestroy') }}",
            deleteButtonLabel: '{{ trans('global.datatables.delete') }}',
            zeroSelectedLabel: '{{ trans('global.datatables.zero_selected') }}',
            areYouSureLabel: '{{ trans('global.areYouSure') }}',
@endcan
        });
    });
</script>
@endsection
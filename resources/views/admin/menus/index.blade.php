@extends('layouts.admin')
@section('content')
@can('menu_create')
    <div style="margin-bottom: 10px;" class="row">
        <div class="col-lg-12">
            <a class="btn btn-success" href="{{ route('admin.menus.create') }}">
                {{ trans('global.add') }} {{ trans('cruds.menu.title_singular') }}
            </a>
        </div>
    </div>
@endcan
<div class="card">
    <div class="card-header">
        {{ trans('cruds.menu.title_singular') }} {{ trans('global.list') }}
    </div>

    <div class="card-body">
        <table class=" table table-bordered table-striped table-hover ajaxTable datatable datatable-Menu">
            <thead>
                <tr>
                    <th width="10">

                    </th>
                    <th>
                        {{ trans('cruds.menu.fields.id') }}
                    </th>
                    <th>
                        {{ trans('cruds.menu.fields.title') }}
                    </th>
                    <th>
                        {{ trans('cruds.menu.fields.link_type') }}
                    </th>
                    <th>
                        {{ trans('cruds.menu.fields.created_at') }}
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
                            @foreach(App\Models\Menu::LINK_TYPE_RADIO as $key => $item)
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
        const table = initAdminDataTable('.datatable-Menu', {
            ajax: "{{ route('admin.menus.index') }}",
            columns: [
                { data: 'placeholder', name: 'placeholder', orderable: false, searchable: false },
                { data: 'id', name: 'id' },
                { data: 'title', name: 'title' },
                { data: 'link_type', name: 'link_type' },
                { data: 'created_at', name: 'created_at' },
                { data: 'actions', name: '{{ trans('global.actions') }}', orderable: false, searchable: false },
            ],
            order: [[2, 'desc']],
            extra: {
                rowReorder: {
                    selector: 'tr td:not(:first-of-type,:last-of-type)',
                    dataSrc: 'position',
                },
            },
@can('menu_delete')
            deleteRoute: "{{ route('admin.menus.massDestroy') }}",
            deleteButtonLabel: '{{ trans('global.datatables.delete') }}',
            zeroSelectedLabel: '{{ trans('global.datatables.zero_selected') }}',
            areYouSureLabel: '{{ trans('global.areYouSure') }}',
@endcan
        });

        table.on('row-reorder', function (e, details) {
            if (!details.length) {
                return;
            }

            const rows = details.map(function (element) {
                return {
                    id: table.row(element.node).data().id,
                    position: element.newData,
                };
            });

            $.ajax({
                headers: { 'x-csrf-token': _token },
                method: 'POST',
                url: "{{ route('admin.menus.reorder') }}",
                data: { rows },
            }).done(function () {
                table.ajax.reload();
            });
        });
    });
</script>
@endsection
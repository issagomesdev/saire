@extends('layouts.admin')
@section('content')
@can('gallery_create')
    <div style="margin-bottom: 10px;" class="row">
        <div class="col-lg-12">
            <a class="btn btn-success" href="{{ route('admin.galleries.create') }}">
                {{ trans('global.add') }} {{ trans('cruds.gallery.title') }}
            </a>
        </div>
    </div>
@endcan
<div class="card">
    <div class="card-header">
        {{ trans('cruds.gallery.title_singular') }} {{ trans('global.list') }}
    </div>

    <div class="card-body">
        <table class=" table table-bordered table-striped table-hover ajaxTable datatable datatable-Gallery">
            <thead>
                <tr>
                    <th width="10">

                    </th>
                    <th>
                        {{ trans('cruds.gallery.fields.id') }}
                    </th>
                    <th>
                        {{ trans('cruds.gallery.fields.title') }}
                    </th>
                    <th>
                        {{ trans('cruds.gallery.fields.categories') }}
                    </th>
                    <th>
                        {{ trans('cruds.gallery.fields.created_at') }}
                    </th>
                    <th>
                        {{ trans('cruds.gallery.fields.updated_at') }}
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
                        <select class="search">
                            <option value>{{ trans('global.all') }}</option>
                            @foreach($categories as $key => $item)
                                <option value="{{ $item->title }}">{{ $item->title }}</option>
                            @endforeach
                        </select>
                    </td>
                    <td>
                        <input class="search" type="text" placeholder="{{ trans('global.search') }}">
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
        initAdminDataTable('.datatable-Gallery', {
            ajax: "{{ route('admin.galleries.index') }}",
            columns: [
                { data: 'placeholder', name: 'placeholder', orderable: false, searchable: false },
                { data: 'id', name: 'id' },
                { data: 'title', name: 'title' },
                { data: 'categories', name: 'categories' },
                { data: 'created_at', name: 'created_at' },
                { data: 'updated_at', name: 'updated_at' },
                { data: 'actions', name: '{{ trans('global.actions') }}', orderable: false, searchable: false },
            ],
            order: [[1, 'desc']],
@can('gallery_delete')
            deleteRoute: "{{ route('admin.galleries.massDestroy') }}",
            deleteButtonLabel: '{{ trans('global.datatables.delete') }}',
            zeroSelectedLabel: '{{ trans('global.datatables.zero_selected') }}',
            areYouSureLabel: '{{ trans('global.areYouSure') }}',
@endcan
        });
    });
</script>
@endsection
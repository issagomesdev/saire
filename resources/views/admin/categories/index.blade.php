@extends('layouts.admin')
@section('content')
@can('category_create')
    <div style="margin-bottom: 10px;" class="row">
        <div class="col-lg-12">
            <a class="btn btn-success" href="{{ route('admin.categories.create') }}">
                {{ trans('global.add') }} {{ trans('cruds.category.title_singular') }}
            </a>
        </div>
    </div>
@endcan
<div class="card">
    <div class="card-header">
        {{ trans('cruds.category.title') }} {{ trans('global.list') }}
    </div> 

    <div class="card-body">
        <table class=" table table-bordered table-striped table-hover ajaxTable datatable datatable-Category">
            <thead>
                <tr>
                    <th width="10">

                    </th>
                    <th>
                        {{ trans('cruds.category.fields.id') }}
                    </th>
                    <th>
                        {{ trans('cruds.category.fields.title') }}
                    </th>
                    <th>
                        {{ trans('cruds.category.fields.created_at') }}
                    </th>
                    <th>
                        {{ trans('cruds.category.fields.updated_at') }}
                    </th>
                    <th>
                        &nbsp;
                    </th>
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
        initAdminDataTable('.datatable-Category', {
            ajax: "{{ route('admin.categories.index') }}",
            columns: [
                { data: 'placeholder', name: 'placeholder', orderable: false, searchable: false },
                { data: 'id', name: 'id' },
                { data: 'title', name: 'title' },
                { data: 'created_at', name: 'created_at' },
                { data: 'updated_at', name: 'updated_at' },
                { data: 'actions', name: '{{ trans('global.actions') }}', orderable: false, searchable: false },
            ],
            order: [[1, 'desc']],
@can('category_delete')
            deleteRoute: "{{ route('admin.categories.massDestroy') }}",
            deleteButtonLabel: '{{ trans('global.datatables.delete') }}',
            zeroSelectedLabel: '{{ trans('global.datatables.zero_selected') }}',
            areYouSureLabel: '{{ trans('global.areYouSure') }}',
@endcan
        });
    });
</script>
@endsection
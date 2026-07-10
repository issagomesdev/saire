@extends('layouts.admin')
@section('content')
@can('permission_create')
    <div style="margin-bottom: 10px;" class="row">
        <div class="col-lg-12">
        </div>
    </div>
@endcan
<div class="card">
    <div class="card-header">
        {{ trans('cruds.permission.title') }} {{ trans('global.list') }}
    </div>

    <div class="card-body">
        <div class="table-responsive">
            <table class=" table table-bordered table-striped table-hover ajaxTable datatable datatable-Permission">
                <thead>
                    <tr>
                        <th width="10">

                        </th>
                        <th>
                            {{ trans('cruds.permission.fields.title') }}
                        </th>
                    </tr>
                </thead>
            </table>
        </div>
    </div>
</div>

<style>

.buttons-select-none.btn-primary.disabled,
.btn-danger {
    display: none;
}


</style>

@endsection
@section('scripts')
@parent
<script>
    $(function () {
        initAdminDataTable('.datatable-Permission', {
            ajax: "{{ route('admin.permissions.index') }}",
            columns: [
                { data: 'placeholder', name: 'placeholder', orderable: false, searchable: false },
                { data: 'id', name: 'id', visible: false, searchable: false },
                { data: 'lab', name: 'lab' },
            ],
            order: [[2, 'desc']],
@can('permission_delete')
            deleteRoute: "{{ route('admin.permissions.massDestroy') }}",
            deleteButtonLabel: '{{ trans('global.datatables.delete') }}',
            zeroSelectedLabel: '{{ trans('global.datatables.zero_selected') }}',
            areYouSureLabel: '{{ trans('global.areYouSure') }}',
@endcan
        });
    });
</script>
@endsection
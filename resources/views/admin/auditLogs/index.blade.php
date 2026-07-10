@extends('layouts.admin')
@section('content')

<div class="card">
    <div class="card-header">
        {{ trans('cruds.auditLog.title') }} {{ trans('global.list') }}
    </div>

    <div class="card-body">
        <div class="table-responsive">
            <table class=" table table-bordered table-striped table-hover ajaxTable datatable datatable-AuditLog">
                <thead>
                    <tr>
                        <th width="10">

                        </th>
                        <th>
                            {{ trans('cruds.auditLog.fields.id') }}
                        </th>
                        <th>
                            {{ trans('cruds.auditLog.fields.description') }}
                        </th>
                        <th>
                            {{ trans('cruds.auditLog.fields.subject_id') }}
                        </th>
                        <th>
                            {{ trans('cruds.auditLog.fields.subject_type') }}
                        </th>
                        <th>
                            {{ trans('cruds.auditLog.fields.user_id') }}
                        </th>
                        <th>
                            {{ trans('cruds.auditLog.fields.host') }}
                        </th>
                        <th>
                            {{ trans('cruds.auditLog.fields.created_at') }}
                        </th>
                        <th>
                            &nbsp;
                        </th>
                    </tr>
                </thead>
            </table>
        </div>
    </div>
</div>



@endsection
@section('scripts')
@parent
<script>
    $(function () {
        initAdminDataTable('.datatable-AuditLog', {
            ajax: "{{ route('admin.audit-logs.index') }}",
            columns: [
                { data: 'placeholder', name: 'placeholder', orderable: false, searchable: false },
                { data: 'id', name: 'id' },
                { data: 'description', name: 'description' },
                { data: 'subject_id', name: 'subject_id' },
                { data: 'subject_type', name: 'subject_type' },
                { data: 'user_id', name: 'user_id' },
                { data: 'host', name: 'host' },
                { data: 'created_at', name: 'created_at' },
                { data: 'actions', name: 'actions', orderable: false, searchable: false },
            ],
            order: [[1, 'desc']],
        });
    });
</script>
@endsection
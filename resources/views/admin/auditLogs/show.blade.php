@extends('layouts.admin')
@section('content')

<div class="card">
    <div class="card-header">
        {{ trans('global.show') }} {{ trans('cruds.auditLog.title') }}
    </div>

    <div class="card-body">
        <div class="form-group">
            <div class="form-group">
                <a class="btn btn-default" href="{{ route('admin.audit-logs.index') }}">
                    {{ trans('global.back_to_list') }}
                </a>
            </div>
            <table class="table table-bordered table-striped">
                <tbody>
                    <tr>
                        <th>
                            {{ trans('cruds.auditLog.fields.id') }}
                        </th>
                        <td>
                            {{ $auditLog->id }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.auditLog.fields.description') }}
                        </th>
                        <td>
                            {{ $auditLog->description }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.auditLog.fields.subject_id') }}
                        </th>
                        <td>
                            @if(strcmp(substr($auditLog->subject_type, -1), "y") == 0)
                            <a href="{{ route('admin.' . strtolower( rtrim($auditLog->subject_type, "y") ) . 'ies.show', $auditLog->subject_id ) }}">
                            #{{$auditLog->subject_id}}
                            </a>
                            @else
                            <a href="{{ route('admin.' . strtolower($auditLog->subject_type) . 's.show', $auditLog->subject_id ) }}">
                            #{{$auditLog->subject_id}}
                            </a> 
                            @endif
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.auditLog.fields.subject_type') }}
                        </th>
                        <td>
                        {{ trans('cruds.' . strtolower($auditLog->subject_type) . '.title') }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.auditLog.fields.user_id') }}
                        </th>
                        <td>
                            <a href="{{ route('admin.users.show', $auditLog->user_id ) }}">
                                {{ $auditLog->user->name ?? '' }}
                            </a>
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.auditLog.fields.properties') }}
                        </th>
                        <td>
                            {{ $auditLog->properties }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.auditLog.fields.host') }}
                        </th>
                        <td>
                            {{ $auditLog->host }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.auditLog.fields.created_at') }}
                        </th>
                        <td>
                            {{ $auditLog->created_at }}
                        </td>
                    </tr>
                </tbody>
            </table>
            <div class="form-group">
                <a class="btn btn-default" href="{{ route('admin.audit-logs.index') }}">
                    {{ trans('global.back_to_list') }}
                </a>
            </div>
        </div>
    </div>
</div>



@endsection
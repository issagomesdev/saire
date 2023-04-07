@extends('layouts.admin')
@section('content')

<div class="card">
    <div class="card-header">
        {{ trans('global.show') }} {{ trans('cruds.publication.title_singular') }}
    </div>

    <div class="card-body">
        <div class="form-group">
            <div class="form-group">
                <a class="btn btn-default" href="{{ route('admin.publications.index') }}">
                    {{ trans('global.back_to_list') }}
                </a>
            </div>
            <table class="table table-bordered table-striped">
                <tbody>
                    <tr>
                        <th>
                            {{ trans('cruds.publication.fields.id') }}
                        </th>
                        <td>
                            {{ $publication->id }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.publication.fields.title') }}
                        </th>
                        <td>
                            {{ $publication->title }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.publication.fields.text') }}
                        </th>
                        <td>
                            {!! $publication->text !!}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.publication.fields.photos') }}
                        </th>
                        <td>
                            @foreach($publication->photos as $key => $media)
                                <a href="{{ $media->getUrl() }}" target="_blank" style="display: inline-block">
                                    <img src="{{ $media->getUrl('thumb') }}">
                                </a>
                            @endforeach
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.publication.fields.categories') }}
                        </th>
                        <td>
                            @foreach($publication->categories as $key => $categories)
                                <span class="label label-info">{{ $categories->title }}</span>
                            @endforeach
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.publication.fields.created_at') }}
                        </th>
                        <td>
                            {{ $publication->created_at }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.publication.fields.updated_at') }}
                        </th>
                        <td>
                            {{ $publication->updated_at }}
                        </td>
                    </tr>
                </tbody>
            </table>
            <div class="form-group">
                <a class="btn btn-default" href="{{ route('admin.publications.index') }}">
                    {{ trans('global.back_to_list') }}
                </a>
            </div>
        </div>
    </div>
</div>



@endsection
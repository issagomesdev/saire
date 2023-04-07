@extends('layouts.admin')
@section('content')

<div class="card">
    <div class="card-header">
        {{ trans('global.edit') }} {{ trans('cruds.submenu.title_singular') }}
    </div>

    <div class="card-body">
        <form method="POST" action="{{ route("admin.submenus.update", [$submenu->id]) }}" enctype="multipart/form-data">
            @method('PUT')
            @csrf
            <div class="form-group">
                <label class="required" for="title">{{ trans('cruds.submenu.fields.title') }}</label>
                <input class="form-control {{ $errors->has('title') ? 'is-invalid' : '' }}" type="text" name="title" id="title" value="{{ old('title', $submenu->title) }}" required>
                @if($errors->has('title'))
                    <div class="invalid-feedback">
                        {{ $errors->first('title') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.submenu.fields.title_helper') }}</span>
            </div>
            <div class="form-group">
                <label class="required">{{ trans('cruds.submenu.fields.link_type') }}</label>
                @foreach(App\Models\Submenu::LINK_TYPE_RADIO as $key => $label)
                    <div class="form-check {{ $errors->has('link_type') ? 'is-invalid' : '' }}">
                        <input class="form-check-input" type="radio" id="link_type_{{ $key }}" name="link_type" value="{{ $key }}" {{ old('link_type', $submenu->link_type) === (string) $key ? 'checked' : '' }} required>
                        <label class="form-check-label" for="link_type_{{ $key }}">{{ $label }}</label>
                    </div>
                @endforeach
                @if($errors->has('link_type'))
                    <div class="invalid-feedback">
                        {{ $errors->first('link_type') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.submenu.fields.link_type_helper') }}</span>
            </div>
            <div class="form-group" id="page">
                <label for="page_id">{{ trans('cruds.submenu.fields.page') }}</label>
                <select class="form-control select2 {{ $errors->has('page') ? 'is-invalid' : '' }}" name="page_id" id="page_id">
                    @foreach($pages as $id => $entry)
                        <option value="{{ $id }}" {{ (old('page_id') ? old('page_id') : $submenu->page->id ?? '') == $id ? 'selected' : '' }}>{{ $entry }}</option>
                    @endforeach
                </select>
                @if($errors->has('page'))
                    <div class="invalid-feedback">
                        {{ $errors->first('page') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.submenu.fields.page_helper') }}</span>
            </div>
            <div class="form-group" id="url">
                <label for="url">{{ trans('cruds.submenu.fields.url') }}</label>
                <input class="form-control {{ $errors->has('url') ? 'is-invalid' : '' }}" type="text" name="url" id="url" value="{{ old('url', $submenu->url) }}">
                @if($errors->has('url'))
                    <div class="invalid-feedback">
                        {{ $errors->first('url') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.submenu.fields.url_helper') }}</span>
            </div>
            <div class="form-group">
                <button class="btn btn-danger" type="submit">
                    {{ trans('global.save') }}
                </button>
            </div>
        </form>
    </div>
</div>

<script>

const linktype = document.querySelectorAll('input[name="link_type"]');
linktype.forEach(radio => {
    function checked(){
        if(radio.checked && radio.value == 0) {
        document.querySelector('#page').style="display: block";
        document.querySelector('#page select').removeAttribute("disabled")
        document.querySelector('#page select').setAttribute("required", "true")

        document.querySelector('#url').style="display: none";
        document.querySelector('#url input').setAttribute("disabled", "true")
        document.querySelector('#url input').removeAttribute("required")
    } else if(radio.checked && radio.value == 1) {
        document.querySelector('#url').style="display: block";
        document.querySelector('#url input').removeAttribute("disabled")
        document.querySelector('#url input').setAttribute("required", "true")

        document.querySelector('#page').style="display: none";
        document.querySelector('#page select').setAttribute("disabled", "true")
        document.querySelector('#page select').removeAttribute("required")
    }
    }
    checked()
    radio.addEventListener('change', () => {
        checked()
  });
});

</script>

@endsection
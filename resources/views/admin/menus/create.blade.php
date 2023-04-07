@extends('layouts.admin')
@section('content')

<div class="card">
    <div class="card-header">
        {{ trans('global.create') }} {{ trans('cruds.menu.title_singular') }}
    </div>

    <div class="card-body">
        <form method="POST" action="{{ route("admin.menus.store") }}" enctype="multipart/form-data">
            @csrf
            <div class="form-group">
                <label class="required" for="title">{{ trans('cruds.menu.fields.title') }}</label>
                <input class="form-control {{ $errors->has('title') ? 'is-invalid' : '' }}" type="text" name="title" id="title" value="{{ old('title', '') }}" required>
                @if($errors->has('title'))
                    <div class="invalid-feedback">
                        {{ $errors->first('title') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.menu.fields.title_helper') }}</span>
            </div>
            <div class="form-group">
                <label class="required">{{ trans('cruds.menu.fields.link_type') }}</label>
                @foreach(App\Models\Menu::LINK_TYPE_RADIO as $key => $label)
                    <div class="form-check {{ $errors->has('link_type') ? 'is-invalid' : '' }}">
                        <input class="form-check-input" type="radio" id="link_type_{{ $key }}" name="link_type" value="{{ $key }}" {{ old('link_type', '') === (string) $key ? 'checked' : '' }} required>
                        <label class="form-check-label" for="link_type_{{ $key }}">{{ $label }}</label>
                    </div>
                @endforeach
                @if($errors->has('link_type'))
                    <div class="invalid-feedback">
                        {{ $errors->first('link_type') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.menu.fields.link_type_helper') }}</span>
            </div>

            
            <div class="form-group" id="submenu" style="display: none">
                <label class="required" for="submenuses">{{ trans('cruds.menu.fields.submenus') }}</label>
                <div style="padding-bottom: 4px">
                    <span class="btn btn-info btn-xs select-all" style="border-radius: 0">{{ trans('global.select_all') }}</span>
                    <span class="btn btn-info btn-xs deselect-all" style="border-radius: 0">{{ trans('global.deselect_all') }}</span>
                </div>
                <select class="form-control select2 {{ $errors->has('submenuses') ? 'is-invalid' : '' }}" name="submenuses[]" id="submenuses" multiple disabled>
                    @foreach($submenuses as $id => $submenus)
                        <option value="{{ $id }}" {{ in_array($id, old('submenuses', [])) ? 'selected' : '' }}>{{ $submenus }}</option>
                    @endforeach
                </select>
                @if($errors->has('submenuses'))
                    <div class="invalid-feedback">
                        {{ $errors->first('submenuses') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.menu.fields.submenus_helper') }}</span>
            </div>
            <div class="form-group" id="page" style="display: none">
                <label class="required" for="page_id">{{ trans('cruds.menu.fields.page') }}</label>
                <select class="form-control select2 {{ $errors->has('page') ? 'is-invalid' : '' }}" name="page_id" id="page_id" disabled>
                    @foreach($pages as $id => $entry)
                        <option value="{{ $id }}" {{ old('page_id') == $id ? 'selected' : '' }}>{{ $entry }}</option>
                    @endforeach
                </select>
                @if($errors->has('page'))
                    <div class="invalid-feedback">
                        {{ $errors->first('page') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.menu.fields.page_helper') }}</span>
            </div>
            <div class="form-group" id="url" style="display: none">
                <label class="required" for="url">{{ trans('cruds.menu.fields.url') }}</label>
                <input class="form-control {{ $errors->has('url') ? 'is-invalid' : '' }}" type="text" name="url" id="url" value="{{ old('url', '') }}" disabled>
                @if($errors->has('url'))
                    <div class="invalid-feedback">
                        {{ $errors->first('url') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.menu.fields.url_helper') }}</span>
            </div>

            <input type="hidden" id="position" name="position" value="{{$count_menus}}">

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
    if (radio.checked && radio.value == 0) {
        document.querySelector('#submenu').style="display: block";
        document.querySelector('#submenu select').removeAttribute("disabled")
        document.querySelector('#submenu select').setAttribute("required", "true")

        document.querySelector('#page').style="display: none";
        document.querySelector('#page select').setAttribute("disabled", "true")
        document.querySelector('#page select').removeAttribute("required")

        document.querySelector('#url').style="display: none";
        document.querySelector('#url input').setAttribute("disabled", "true")
        document.querySelector('#url input').removeAttribute("required")

    } else if(radio.checked && radio.value == 1) {
        document.querySelector('#page').style="display: block";
        document.querySelector('#page select').removeAttribute("disabled")
        document.querySelector('#page select').setAttribute("required", "true")

        document.querySelector('#submenu').style="display: none";
        document.querySelector('#submenu select').setAttribute("disabled", "true")
        document.querySelector('#submenu select').removeAttribute("required")

        document.querySelector('#url').style="display: none";
        document.querySelector('#url input').setAttribute("disabled", "true")
        document.querySelector('#url input').removeAttribute("required")
    } else if(radio.checked && radio.value == 2) {
        document.querySelector('#url').style="display: block";
        document.querySelector('#url input').removeAttribute("disabled")
        document.querySelector('#url input').setAttribute("required", "true")

        document.querySelector('#submenu').style="display: none";
        document.querySelector('#submenu select').setAttribute("disabled", "true")
        document.querySelector('#submenu select').removeAttribute("required")

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
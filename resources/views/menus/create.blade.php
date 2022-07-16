@extends('crud.create')

@section('form')
    <div class="row">
        <div class="col-6">
            <x-adminlte-input-switch name="featured" data-on-text="Yes" data-off-text="No" label="Featured"
                enable-old-support />
        </div>
        <div class="col-6">
            <x-adminlte-input-switch name="is_active" data-on-text="Yes" data-off-text="No" label="Active" enable-old-support
                checked />
        </div>
    </div>
    <x-adminlte-input id="name" name="name" label="Name" value="{{ old('name') }}" />
    <x-adminlte-input id="price" name="price" label="Price" value="{{ old('price') }}" />
    <x-adminlte-textarea id="description" name="description" label="Description">
        {{ old('description') }}
    </x-adminlte-textarea>
    <x-adminlte-select2 id="categories" name="categories[]" label="Categories" multiple>
        <x-adminlte-options :options="$categories" />
    </x-adminlte-select2>
    <span class="invalid-feedback d-block" role="alert">
        <strong>{{ $errors->first('categories.*') }}</strong>
    </span>
    <img id="image-preview" class="form-image-preview" style="display:none;">
    <x-adminlte-input-file id="image" name="image" label="Image" placeholder="Choose an image..." />
@endsection

@section('js')
    @include('partials.price-formatter-script')
    @include('partials.preview-image-script')
@endsection

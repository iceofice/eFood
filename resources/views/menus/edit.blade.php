@extends('crud.edit')

@section('form')
    <x-adminlte-input id="name" name="name" label="Name" value="{{ $menu->name }}" />
    <x-adminlte-input id="slug" name="slug" label="Slug" value="{{ $menu->slug }}" />
    <x-adminlte-input id="price" name="price" label="Price" value="{{ $menu->price }}" />
    <x-adminlte-textarea id="description" name="description" label="Description">
        {{ $menu->description }}
    </x-adminlte-textarea>

    <x-adminlte-select2 id="categories" name="categories[]" label="Categories" multiple>
        <x-adminlte-options :options="$categories" :selected="$menu->category_id_list" />
    </x-adminlte-select2>
    <span class="invalid-feedback d-block" role="alert">
        <strong>{{ $errors->first('categories.*') }}</strong>
    </span>

    <img id="image-preview" src="{{ url('storage/images/' . $menu->image) }}" class="form-image-preview"
        style="display: {{ $menu->image ? 'block' : 'none' }};">
    <x-adminlte-input-file id="image" name="image" label="Image" placeholder="Choose an image..." />
@endsection

@section('js')
    @include('partials.price-formatter-script')
    @include('partials.preview-image-script')
@endsection

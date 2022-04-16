@extends('crud.edit')

@section('form')
    <x-adminlte-select name="type" label="Type" enable-old-support>
        <x-adminlte-options :options="['Category', 'Filter']" selected="{{ $category->type }}" />
    </x-adminlte-select>

    <x-adminlte-input id="name" name="name" label="Name" value="{{ $category->name }}" />
    <x-adminlte-input id="slug" name="slug" label="Slug" value="{{ $category->slug }}" />
    <x-adminlte-textarea id="description" name="description" label="Description">
        {{ $category->description }}
    </x-adminlte-textarea>

    <img id="image-preview" src="{{ url('storage/images/' . $category->image) }}" class="form-image-preview"
        style="display: {{ $category->image ? 'block' : 'none' }};">
    <x-adminlte-input-file id="image" name="image" label="Image" placeholder="Choose an image..." />
@endsection

@section('js')
    @include('partials.preview-image-script')
@endsection

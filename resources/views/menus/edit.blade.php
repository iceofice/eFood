@extends('crud.edit')

@section('form')
    <x-adminlte-input-switch name="featured" data-on-text="Yes" data-off-text="No" label="Featured" :checked="$menu->featured ? true : false" />
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

    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Inventory Items</h3>
                </div>
                <div class="card-body">
                    <a data-toggle='modal' data-target='#add-modal' class="btn btn-primary mb-4">
                        <i class="fa fa-plus mr-2"></i>Add New Items
                    </a>
                    @if ($errors->any())
                        <div class="alert alert-danger">
                            <ul>
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <x-adminlte-datatable id="table2" :heads="$table->heads" head-theme="dark" :config="$table->config" striped
                        hoverable bordered />
                </div>
            </div>
        </div>
    </div>
@endsection

@section('js')
    @include('partials.price-formatter-script')
    @include('partials.preview-image-script')
@endsection

@section('additional')
    @include('menus.add-item-modal')
    @include('menus.remove-item-modal')
    @include('menus.edit-item-modal')
@endsection

@extends('layouts.app')

@section('content')
    @include('admin.adverts.categories._nav')

    <div class="d-flex flex-row mb-3">
        <a href="{{ route('categories.attributes.edit', [$category, $attribute]) }}" class="btn btn-primary mr-1">Edit</a>
        <form method="POST" action="{{ route('categories.attributes.destroy', [$category, $attribute]) }}" class="mr-1">
            @csrf
            @method('DELETE')
            <button class="btn btn-danger">Delete</button>
        </form>
    </div>

    <table class="table table-bordered table-striped">
        <tbody>
        <tr>
            <th>ID</th><td>{{ $category->id }}</td>
        </tr>
        <tr>
            <th>Name</th><td>{{ $category->name }}</td>
        </tr>
        <tr>
            <th>Slug</th><td>{{ $category->slug }}</td>
        </tr>
        <tbody>
        </tbody>
    </table>
    <table class="table table-bordered">

        <thead>
        <tr><th colspan="4">Attributes</th></tr>
        <tr>
            <th>Sort</th>
            <th>Name</th>
            <th>Slug</th>
            <th>Required</th>
        </tr>
        </thead>
        <tbody>




            <tr>
                <td>{{ $attribute->sort }}</td>
                <td>{{ $attribute->name }}</td>
                <td>{{ $attribute->type }}</td>
                <td>{{ $attribute->required ? 'Yes' : '' }}</td>
            </tr>




        </tbody>
    </table>
@endsection
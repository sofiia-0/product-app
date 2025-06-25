@extends('layouts.main')

@section('content')
<h1 class="mb-4">Categories CRUD</h1>

{{-- Mensajes --}}
@if(session('success'))
    <div class="alert alert-success">{{ session('success') }}</div>
@endif

@if($errors->any())
    <div class="alert alert-danger">
        <ul class="mb-0">
            @foreach($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif

{{-- Formulario categorías --}}
<form action="{{ isset($category) ? route('categories.update', $category) : route('categories.store') }}" method="POST" class="mb-5">
    @csrf
    @if(isset($category))
        @method('PUT')
    @endif

    <div class="mb-3">
        <label for="name" class="form-label">Name</label>
        <input type="text" name="name" class="form-control" value="{{ old('name', $category->name ?? '') }}" required>
    </div>

    <div class="mb-3">
        <label for="description" class="form-label">Description</label>
        <textarea name="description" class="form-control" rows="3">{{ old('description', $category->description ?? '') }}</textarea>
    </div>

    <button type="submit" class="btn btn-success">{{ isset($category) ? 'Update' : 'Create' }}</button>
    @if(isset($category))
        <a href="{{ route('categories.index') }}" class="btn btn-secondary">Cancel</a>
    @endif
</form>

{{-- Tabla categorías --}}
<table class="table table-bordered">
    <thead>
        <tr>
            <th>Name</th>
            <th>Description</th>
            <th>Actions</th>
        </tr>
    </thead>
    <tbody>
        @foreach($categories as $cat)
        <tr>
            <td>{{ $cat->name }}</td>
            <td>{{ $cat->description }}</td>
            <td>
                <a href="{{ route('categories.index', ['edit' => $cat->id]) }}" class="btn btn-warning btn-sm">Edit</a>
                <form action="{{ route('categories.destroy', $cat) }}" method="POST" style="display:inline;">
                    @csrf
                    @method('DELETE')
                    <button class="btn btn-danger btn-sm" onclick="return confirm('Are you sure?')">Delete</button>
                </form>
            </td>
        </tr>
        @endforeach
    </tbody>
</table>
@endsection

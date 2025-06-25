@extends('layouts.main')

@section('content')
<style>
    body {
        background: #E8E2D4;
    }
    .modern-card {
        background: #fff;
        border-radius: 18px;
        box-shadow: 0 4px 24px rgba(67, 103, 65, 0.08);
        padding: 2rem;
        margin-bottom: 2rem;
    }
    .modern-btn-success {
        background: #436741;
        color: #fff;
        border: none;
        transition: background 0.2s;
    }
    .modern-btn-success:hover {
        background: #365432;
    }
    .modern-btn-secondary {
        background: #E1C1C6;
        color: #436741;
        border: none;
        transition: background 0.2s;
    }
    .modern-btn-secondary:hover {
        background: #e8e2d4;
    }
    .modern-table th {
        background: #436741;
        color: #fff;
        border: none;
    }
    .modern-table td {
        background: #fff;
        color: #436741;
        vertical-align: middle;
    }
    .modern-table tr {
        border-bottom: 1px solid #E1C1C6;
    }
    .form-label {
        color: #436741;
        font-weight: 600;
    }
    .alert-success {
        background: #E1C1C6;
        color: #436741;
        border: none;
    }
    .alert-danger {
        background: #fff0f3;
        color: #b94a48;
        border: none;
    }
</style>

<div class="modern-card">
    <h1 class="mb-4" style="color:#436741; font-weight:700;">Products CRUD</h1>

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

    {{-- Formulario productos --}}
    <form action="{{ isset($product) ? route('products.update', $product) : route('products.store') }}" method="POST" class="mb-5">
        @csrf
        @if(isset($product))
            @method('PUT')
        @endif

        <div class="mb-3">
            <label for="name" class="form-label">Name</label>
            <input type="text" name="name" class="form-control" style="border-radius:18px; border:2px solid #E1C1C6; background:#F8F5F0;" value="{{ old('name', $product->name ?? '') }}" required>
        </div>

        <div class="mb-3">
            <label for="price" class="form-label">Price</label>
            <input type="number" step="0.01" name="price" class="form-control" style="border-radius:18px; border:2px solid #E1C1C6; background:#F8F5F0;" value="{{ old('price', $product->price ?? '') }}" required>
        </div>

        <div class="mb-3">
            <label for="category_id" class="form-label">Category</label>
            <select name="category_id" class="form-select" style="border-radius:18px; border:2px solid #E1C1C6; background:#F8F5F0;" required>
                <option value="">-- Select Category --</option>
                @foreach($categories as $category)
                    <option value="{{ $category->id }}" {{ (old('category_id', $product->category_id ?? '') == $category->id) ? 'selected' : '' }}>
                        {{ $category->name }}
                    </option>
                @endforeach
            </select>
        </div>

        <div class="mb-3">
            <label for="description" class="form-label">Description</label>
            <textarea name="description" class="form-control" style="border-radius:18px; border:2px solid #E1C1C6; background:#F8F5F0;" rows="3">{{ old('description', $product->description ?? '') }}</textarea>
        </div>

        <button type="submit" class="btn modern-btn-success">{{ isset($product) ? 'Update' : 'Create' }}</button>
        @if(isset($product))
            <a href="{{ route('products.index') }}" class="btn modern-btn-secondary">Cancel</a>
        @endif
    </form>
</div>

<div class="modern-card">
    <table class="table modern-table table-bordered">
        <thead>
            <tr>
                <th>Name</th>
                <th>Price</th>
                <th>Category</th>
                <th>Description</th>
                <th style="width:140px;">Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach($products as $prod)
            <tr>
                <td>{{ $prod->name }}</td>
                <td>${{ number_format($prod->price, 2) }}</td>
                <td>{{ $prod->category->name }}</td>
                <td>{{ $prod->description }}</td>
                <td>
                    <a href="{{ route('products.index', ['edit' => $prod->id]) }}" class="btn btn-warning btn-sm" style="border-radius:8px;">Edit</a>
                    <form action="{{ route('products.destroy', $prod) }}" method="POST" style="display:inline;">
                        @csrf
                        @method('DELETE')
                        <button class="btn btn-danger btn-sm" style="border-radius:8px;" onclick="return confirm('Are you sure?')">Delete</button>
                    </form>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection

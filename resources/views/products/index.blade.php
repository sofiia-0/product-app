@extends('layouts.main')

@section('content')
<style>
    body {
        background: #E8E2D4;
    }
    .modern-card {
        background: #F8F5F0;
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
        text-align: center;
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
    <h1 class="mb-4" style="color:#436741; font-weight:700;">{{ __('products.crud_title') }}</h1>

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
            <label for="name" class="form-label">{{ __('products.name') }}</label>
            <input type="text" name="name" class="form-control" style="border-radius:18px; border:2px solid #E1C1C6; background:#F8F5F0;" value="{{ old('name', $product->name ?? '') }}" required>
        </div>

        <div class="mb-3">
            <label for="price" class="form-label">{{ __('products.price') }}</label>
            <input type="number" step="0.01" name="price" class="form-control" style="border-radius:18px; border:2px solid #E1C1C6; background:#F8F5F0;" value="{{ old('price', $product->price ?? '') }}" required>
        </div>

        <div class="mb-3">
            <label for="category_id" class="form-label">{{ __('products.category') }}</label>
            <select name="category_id" class="form-select" style="border-radius:18px; border:2px solid #E1C1C6; background:#F8F5F0;" required>
                <option value="">{{ __('products.select_category') }}</option>
                @foreach($categories as $category)
                    <option value="{{ $category->id }}" {{ (old('category_id', $product->category_id ?? '') == $category->id) ? 'selected' : '' }}>
                        {{ $category->name }}
                    </option>
                @endforeach
            </select>
        </div>

        <div class="mb-3">
            <label for="description" class="form-label">{{ __('products.description') }}</label>
            <textarea name="description" class="form-control" style="border-radius:18px; border:2px solid #E1C1C6; background:#F8F5F0;" rows="3">{{ old('description', $product->description ?? '') }}</textarea>
        </div>

        <button type="submit" class="btn modern-btn-success">{{ isset($product) ? __('products.update') : __('products.create') }}</button>
        @if(isset($product))
            <a href="{{ route('products.index') }}" class="btn modern-btn-secondary">{{ __('products.cancel') }}</a>
        @endif
    </form>
</div>

<div class="modern-card">
    <style>
        /* Estilos para ambas tablas */
        .modern-table {
            border-collapse: separate !important;
            border-spacing: 0;
            border-radius: 18px;
            overflow: hidden;
            width: 100%;
        }
        .modern-table th:first-child {
            border-top-left-radius: 18px;
        }
        .modern-table th:last-child {
            border-top-right-radius: 18px;
        }
        .modern-table tr:last-child td:first-child {
            border-bottom-left-radius: 18px;
        }
        .modern-table tr:last-child td:last-child {
            border-bottom-right-radius: 18px;
        }
        /* Cambia el fondo de las celdas de datos */
        .modern-table td {
            background: #F8F5F0 !important;
            color: #436741;
            vertical-align: middle;
        }
        /* Botones similares a categories */
        .btn-modern-edit {
            padding: 0.25rem 0.75rem;
            font-size: 0.95rem;
            border-radius: 8px;
            background-color: #436741; /* verde */
            color: white;
            border: none;
            text-decoration: none;
            display: inline-block;
        }
        .btn-modern-delete {
            background: #E1C1C6;
            color: #436741;
            border: none;
            padding: 0.25rem 0.75rem;
            font-size: 0.95rem;
            border-radius: 8px;
            cursor: pointer;
        }
        /* Centrar texto en encabezados */
        .modern-table th {
            text-align: center;
        }
    </style>

    <table class="table modern-table table-bordered">
        <thead>
            <tr>
                <th>{{ __('products.name') }}</th>
                <th>{{ __('products.price') }}</th>
                <th>{{ __('products.category') }}</th>
                <th>{{ __('products.description') }}</th>
                <th style="width:140px;">{{ __('products.actions') }}</th>
            </tr>
        </thead>
        <tbody>
            @forelse($products as $prod)
            <tr>
                <td>{{ $prod->name }}</td>
                <td style="text-align:center;">${{ number_format($prod->price, 2) }}</td>
                <td>{{ $prod->category->name }}</td>
                <td>{{ $prod->description }}</td>
                <td>
                    <a href="{{ route('products.index', ['edit' => $prod->id]) }}" class="btn-modern-edit">
                        {{ __('products.edit') }}
                    </a>
                    <form action="{{ route('products.destroy', $prod) }}" method="POST" style="display:inline;">
                        @csrf
                        @method('DELETE')
                        <button class="btn-modern-delete" onclick="return confirm('{{ __('products.confirm_delete') }}')">
                            {{ __('products.delete') }}
                        </button>
                    </form>
                </td>
            </tr>
            @empty
            <tr>
                <td colspan="5" class="text-center">{{ __('products.no_records') }}</td>
            </tr>
            @endforelse
        </tbody>
    </table>
</div>
@endsection

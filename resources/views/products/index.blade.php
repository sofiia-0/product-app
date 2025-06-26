@extends('layouts.main')

@section('content')
<style>
    body {
        background: #E8E2D4;
        font-family: 'Poppins', sans-serif;
    }
    .modern-card {
        background: #F8F5F0;
        border-radius: 18px;
        box-shadow: 0 4px 24px rgba(67, 103, 65, 0.10);
        padding: 2.5rem 2rem;
        margin-bottom: 2.5rem;
        border: 1px solid #E1C1C6;
    }
    .modern-btn-success {
        background: linear-gradient(90deg, #436741 60%, #5a8a4d 100%);
        color: #fff;
        border: none;
        border-radius: 12px;
        padding: 0.5rem 1.5rem;
        font-weight: 600;
        letter-spacing: 0.5px;
        box-shadow: 0 2px 8px rgba(67, 103, 65, 0.08);
        transition: background 0.2s, box-shadow 0.2s;
    }
    .modern-btn-success:hover {
        background: linear-gradient(90deg, #365432 60%, #4e7a3e 100%);
        box-shadow: 0 4px 16px rgba(67, 103, 65, 0.13);
    }
    .modern-btn-secondary {
        background: #E1C1C6;
        color: #436741;
        border: none;
        border-radius: 12px;
        padding: 0.5rem 1.5rem;
        font-weight: 600;
        margin-left: 0.5rem;
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
        font-weight: 700;
        font-size: 1.05rem;
        letter-spacing: 0.5px;
        padding: 0.75rem;
    }
    .modern-table td {
        background: #fff;
        color: #436741;
        vertical-align: middle;
        font-size: 1rem;
        padding: 0.7rem;
    }
    .modern-table tr {
        border-bottom: 1px solid #E1C1C6;
        transition: background 0.15s;
    }
    .modern-table tr:hover td {
        background: #f0ece6 !important;
    }
    .form-label {
        color: #436741;
        font-weight: 600;
        margin-bottom: 0.4rem;
    }
    .form-control, .form-select {
        border-radius: 18px;
        border: 2px solid #E1C1C6;
        background: #F8F5F0;
        color: #436741;
        font-size: 1rem;
        padding: 0.6rem 1rem;
        transition: border 0.2s;
    }
    .form-control:focus, .form-select:focus {
        border-color: #436741;
        background: #fff;
        outline: none;
        box-shadow: 0 0 0 2px #e1c1c6;
    }
    .alert-success {
        background: #E1C1C6;
        color: #436741;
        border: none;
        border-radius: 10px;
        font-weight: 500;
        padding: 0.75rem 1.25rem;
        margin-bottom: 1rem;
    }
    .alert-danger {
        background: #fff0f3;
        color: #b94a48;
        border: none;
        border-radius: 10px;
        font-weight: 500;
        padding: 0.75rem 1.25rem;
        margin-bottom: 1rem;
    }
    /* Modern edit/delete buttons */
    .btn-modern-edit {
        padding: 0.25rem 0.9rem;
        font-size: 0.97rem;
        border-radius: 8px;
        background: linear-gradient(90deg, #436741 60%, #5a8a4d 100%);
        color: white;
        border: none;
        text-decoration: none;
        display: inline-block;
        font-weight: 500;
        margin-right: 0.3rem;
        transition: background 0.2s;
    }
    .btn-modern-edit:hover {
        background: linear-gradient(90deg, #365432 60%, #4e7a3e 100%);
    }
    .btn-modern-delete {
        background: #E1C1C6;
        color: #436741;
        border: none;
        padding: 0.25rem 0.9rem;
        font-size: 0.97rem;
        border-radius: 8px;
        cursor: pointer;
        font-weight: 500;
        transition: background 0.2s;
    }
    .btn-modern-delete:hover {
        background: #e8e2d4;
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

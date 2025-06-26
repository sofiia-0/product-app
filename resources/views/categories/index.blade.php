@extends('layouts.main')

@section('content')
<style>
    /* Reutilizo los estilos que tienes en la vista products */
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
        border-radius: 18px;
        padding: 0.5rem 1.5rem;
        font-weight: 600;
    }
    .modern-btn-success:hover {
        background: #365432;
    }
    .modern-btn-secondary {
        background: #E1C1C6;
        color: #436741;
        border: none;
        transition: background 0.2s;
        border-radius: 18px;
        padding: 0.5rem 1.5rem;
        font-weight: 600;
        text-decoration: none;
        display: inline-block;
        line-height: 1.5;
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
    .btn-warning {
        border-radius: 8px;
        padding: 0.25rem 0.75rem;
    }
    .btn-danger {
        border-radius: 8px;
        padding: 0.25rem 0.75rem;
    }
</style>

<div class="modern-card">
    <h1 class="mb-4" style="color:#436741; font-weight:700;">{{ __('categories.crud_title') }}</h1>

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
            <label for="name" class="form-label">{{ __('categories.name') }}</label>
            <input type="text" name="name" class="form-control" style="border-radius:18px; border:2px solid #E1C1C6; background:#F8F5F0;" value="{{ old('name', $category->name ?? '') }}" required>
        </div>

        <div class="mb-3">
            <label for="description" class="form-label">{{ __('categories.description') }}</label>
            <textarea name="description" class="form-control" style="border-radius:18px; border:2px solid #E1C1C6; background:#F8F5F0;" rows="3">{{ old('description', $category->description ?? '') }}</textarea>
        </div>

        <button type="submit" class="btn modern-btn-success">{{ isset($category) ? __('categories.update') : __('categories.create') }}</button>
        @if(isset($category))
            <a href="{{ route('categories.index') }}" class="btn modern-btn-secondary">{{ __('categories.cancel') }}</a>
        @endif
    </form>
</div>

<div class="modern-card">
    <style>
        /* Bordes redondeados para la tabla y celdas */
        .modern-table {
            border-collapse: separate !important;
            border-spacing: 0;
            border-radius: 18px;
            overflow: hidden;
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
    </style>
    <table class="table modern-table table-bordered">
        <thead>
            <tr>
                <th>{{ __('categories.name') }}</th>
                <th>{{ __('categories.description') }}</th>
                <th style="width:140px;">{{ __('categories.actions') }}</th>
            </tr>
        </thead>
        <tbody>
            @forelse($categories as $cat)
            <tr>
                <td>{{ $cat->name }}</td>
                <td>{{ $cat->description }}</td>
                <td>
                    <a href="{{ route('categories.index', ['edit' => $cat->id]) }}" 
                       class="btn modern-btn-success btn-sm" 
                       style="padding: 0.25rem 0.75rem; font-size: 0.95rem;">
                        {{ __('categories.edit') }}
                    </a>
                    <form action="{{ route('categories.destroy', $cat) }}" method="POST" style="display:inline;">
                        @csrf
                        @method('DELETE')
                        <button class="btn btn-danger btn-sm" style="background:#E1C1C6; color:#436741; border:none; padding:0.25rem 0.75rem; font-size:0.95rem; border-radius:8px;"
                                onclick="return confirm('{{ __('categories.confirm_delete') }}')">
                            {{ __('categories.delete') }}
                        </button>
                    </form>
                </td>
            </tr>
            @empty
            <tr>
                <td colspan="3" class="text-center">{{ __('categories.no_records') }}</td>
            </tr>
            @endforelse
        </tbody>
    </table>
</div>
@endsection

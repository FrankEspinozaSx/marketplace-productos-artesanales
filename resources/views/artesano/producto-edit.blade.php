@extends('layouts.marketplace')

@section('contenido')
<div class="d-flex justify-content-between align-items-center mb-3">
    <div>
        <h3 class="encabezado-vista fw-bold mb-0">Editar Producto y Stock</h3>
        <small class="text-muted">Región: {{ $producto->region ?: 'Huánuco' }} — ID #{{ $producto->id }}</small>
    </div>
    <a href="{{ route('artesano.productos.index') }}" class="btn btn-outline-secondary">Volver al Inventario</a>
</div>

@if($errors->any())
    <div class="alert alert-danger">
        <ul class="mb-0">
            @foreach($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif

<div class="bg-white p-4 border rounded shadow-sm">
    <form action="{{ route('artesano.productos.update', $producto->id) }}" method="POST">
        @csrf
        @method('PUT')

        <div class="row g-3">
            <div class="col-md-6">
                <label class="form-label fw-semibold">Nombre del Producto</label>
                <input type="text" name="nombre" class="form-control" value="{{ old('nombre', $producto->nombre) }}" required>
            </div>

            <div class="col-md-6">
                <label class="form-label fw-semibold">Categoria</label>
                <select name="categoria" class="form-select" required>
                    @foreach($categorias as $cat)
                        <option value="{{ $cat }}" {{ old('categoria', $producto->categoria) === $cat ? 'selected' : '' }}>
                            {{ $cat }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div class="col-md-4">
                <label class="form-label fw-semibold">Region de Origen</label>
                <select name="region" class="form-select">
                    @foreach($regiones as $reg)
                        <option value="{{ $reg }}" {{ old('region', $producto->region ?: 'Huánuco') === $reg ? 'selected' : '' }}>
                            {{ $reg }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div class="col-md-4">
                <label class="form-label fw-semibold">Precio (S/)</label>
                <input type="number" step="0.01" min="1" name="precio" class="form-control" value="{{ old('precio', $producto->precio) }}" required>
            </div>

            <div class="col-md-4">
                <label class="form-label fw-semibold">Stock Disponible (unidades)</label>
                <input type="number" min="0" name="stock" class="form-control" value="{{ old('stock', $producto->stock) }}" required>
                <small class="text-muted">Aumenta aquí cuando repongas inventario.</small>
            </div>

            <div class="col-12">
                <label class="form-label fw-semibold">Descripcion e Historia de la Pieza</label>
                <textarea name="descripcion" rows="3" class="form-control">{{ old('descripcion', $producto->descripcion) }}</textarea>
            </div>
        </div>

        <div class="mt-4 d-flex gap-2">
            <button type="submit" class="btn btn-primario">Guardar Cambios</button>
            <a href="{{ route('artesano.productos.index') }}" class="btn btn-light border">Cancelar</a>
        </div>
    </form>
</div>
@endsection

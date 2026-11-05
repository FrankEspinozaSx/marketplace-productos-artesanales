@extends('layouts.marketplace')

@section('contenido')
<h3 class="encabezado-vista fw-bold mb-4">Configurar Tienda y Publicar Producto</h3>

<div class="bg-white p-4 border rounded shadow-sm">
    <form method="POST" action="{{ route('artesano.productos.store') }}">
        @csrf
        <div class="row g-3">
            <div class="col-md-6">
                <label class="form-label fw-semibold">Nombre de la Tienda Artesanal</label>
                <input type="text" name="nombre_tienda" class="form-control @error('nombre_tienda') is-invalid @enderror" value="{{ old('nombre_tienda', 'Taller Arte Huanuco') }}">
                @error('nombre_tienda') <div class="invalid-feedback">{{ $message }}</div> @enderror
            </div>
            <div class="col-md-6">
                <label class="form-label fw-semibold">Titulo del Producto</label>
                <input type="text" name="nombre_producto" class="form-control @error('nombre_producto') is-invalid @enderror" value="{{ old('nombre_producto') }}" placeholder="Ej. Manta Bordada a Mano">
                @error('nombre_producto') <div class="invalid-feedback">{{ $message }}</div> @enderror
            </div>
            <div class="col-md-4">
                <label class="form-label fw-semibold">Categoria</label>
                <select name="categoria" class="form-select @error('categoria') is-invalid @enderror">
                    <option value="">Seleccione...</option>
                    @foreach($categorias as $cat)
                        <option value="{{ $cat }}">{{ $cat }}</option>
                    @endforeach
                </select>
                @error('categoria') <div class="invalid-feedback">{{ $message }}</div> @enderror
            </div>
            <div class="col-md-4">
                <label class="form-label fw-semibold">Region de Origen</label>
                <select name="region" class="form-select @error('region') is-invalid @enderror">
                    <option value="">Seleccione...</option>
                    @foreach($regiones as $reg)
                        <option value="{{ $reg }}">{{ $reg }}</option>
                    @endforeach
                </select>
                @error('region') <div class="invalid-feedback">{{ $message }}</div> @enderror
            </div>
            <div class="col-md-2">
                <label class="form-label fw-semibold">Precio (S/)</label>
                <input type="number" step="0.01" name="precio" class="form-control @error('precio') is-invalid @enderror" value="{{ old('precio') }}">
                @error('precio') <div class="invalid-feedback">{{ $message }}</div> @enderror
            </div>
            <div class="col-md-2">
                <label class="form-label fw-semibold">Stock</label>
                <input type="number" name="stock" class="form-control @error('stock') is-invalid @enderror" value="{{ old('stock') }}">
                @error('stock') <div class="invalid-feedback">{{ $message }}</div> @enderror
            </div>
            <div class="col-12">
                <label class="form-label fw-semibold">Descripcion e Historia de la Pieza</label>
                <textarea name="descripcion" rows="3" class="form-control @error('descripcion') is-invalid @enderror">{{ old('descripcion') }}</textarea>
                @error('descripcion') <div class="invalid-feedback">{{ $message }}</div> @enderror
            </div>
        </div>
        <button type="submit" class="btn btn-primario mt-3">Validar y Publicar Producto</button>
    </form>
</div>
@endsection

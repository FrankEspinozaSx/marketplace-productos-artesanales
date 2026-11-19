@extends('layouts.marketplace')

@section('contenido')
<div class="d-flex justify-content-between align-items-center mb-3">
    <div>
        <h3 class="encabezado-vista fw-bold mb-0">Catalogo de Productos del Artesano</h3>
        <small class="text-muted">Región principal: Huánuco</small>
    </div>
    <a href="{{ route('artesano.productos.create') }}" class="btn btn-primario">+ Nuevo Producto</a>
</div>

@if(session('success'))
    <div class="alert alert-success fw-semibold shadow-sm">{{ session('success') }}</div>
@endif

<div class="bg-white p-4 border rounded shadow-sm">
    <table class="table table-hover align-middle">
        <thead class="thead-branding">
            <tr>
                <th>ID</th>
                <th>Nombre del Producto</th>
                <th>Categoria</th>
                <th>Region</th>
                <th>Precio</th>
                <th>Stock</th>
                <th>Acciones</th>
            </tr>
        </thead>
        <tbody>
            @forelse($productos as $prod)
                <tr>
                    <td>#{{ $prod->id }}</td>
                    <td class="fw-bold">{{ $prod->nombre }}</td>
                    <td>{{ $prod->categoria }}</td>
                    <td><span class="badge badge-acento">{{ $prod->region ?: 'Huánuco' }}</span></td>
                    <td>S/ {{ number_format((float) $prod->precio, 2) }}</td>
                    <td>
                        {{ $prod->stock }} uds.
                        @if((int) $prod->stock <= 5)
                            <span class="badge bg-warning text-dark ms-1">Stock bajo</span>
                        @endif
                    </td>
                    <td>
                        <a href="{{ route('artesano.productos.edit', $prod->id) }}" class="btn btn-sm btn-outline-primary me-1">
                            Editar / Stock
                        </a>
                        <form action="{{ route('artesano.productos.destroy', $prod->id) }}" method="POST" class="d-inline" onsubmit="return confirm('¿Eliminar este producto?');">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-sm btn-outline-danger">Eliminar</button>
                        </form>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="7" class="text-center text-muted py-4">No hay productos registrados todavía.</td>
                </tr>
            @endforelse
        </tbody>
    </table>
</div>
@endsection

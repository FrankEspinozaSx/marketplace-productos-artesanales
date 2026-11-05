@extends('layouts.marketplace')

@section('contenido')
<div class="d-flex justify-content-between align-items-center mb-3">
    <h3 class="encabezado-vista fw-bold mb-0">Catalogo de Productos del Artesano</h3>
    <a href="{{ route('artesano.productos.create') }}" class="btn btn-primario">+ Nuevo Producto</a>
</div>

<div class="bg-white p-4 border rounded shadow-sm">
    <table class="table table-striped">
        <thead class="thead-branding">
            <tr><th>ID</th><th>Nombre del Producto</th><th>Categoria</th><th>Region</th><th>Precio</th><th>Stock</th></tr>
        </thead>
        <tbody>
            @foreach($productos as $prod)
            <tr>
                <td>#{{ $prod['id'] }}</td>
                <td class="fw-semibold">{{ $prod['nombre'] }}</td>
                <td>{{ $prod['categoria'] }}</td>
                <td>{{ $prod['region'] }}</td>
                <td>{{ $prod['precio'] }}</td>
                <td>{{ $prod['stock'] }} uds.</td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection

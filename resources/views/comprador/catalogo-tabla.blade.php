@extends('layouts.marketplace')

@section('contenido')
<h3 class="encabezado-vista fw-bold mb-4">Explorar Catalogo por Categoria y Region</h3>

<div class="bg-white p-4 border rounded shadow-sm mb-4">
    <h5 class="fw-bold mb-3">Catalogo Disponible</h5>
    <table class="table table-hover">
        <thead class="thead-branding">
            <tr><th>Codigo</th><th>Artesania</th><th>Tienda</th><th>Categoria</th><th>Region</th><th>Precio</th><th>Stock</th></tr>
        </thead>
        <tbody>
            @foreach($catalogo as $item)
            <tr>
                <td>{{ $item['codigo'] }}</td>
                <td class="fw-bold">{{ $item['nombre'] }}</td>
                <td>{{ $item['tienda'] }}</td>
                <td>{{ $item['categoria'] }}</td>
                <td><span class="badge badge-acento">{{ $item['region'] }}</span></td>
                <td>{{ $item['precio'] }}</td>
                <td>{{ $item['stock'] }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>

<div class="bg-white p-4 border rounded shadow-sm">
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h5 class="fw-bold mb-0">Resumen de Mi Carrito de Compras</h5>
        <a href="{{ route('comprador.checkout.form') }}" class="btn btn-primario">Proceder al Pago y Valoracion</a>
    </div>
    <table class="table">
        <thead class="thead-branding">
            <tr><th>Producto</th><th>Cantidad</th><th>Precio Unitario</th><th>Subtotal</th></tr>
        </thead>
        <tbody>
            @foreach($carrito as $c)
            <tr>
                <td>{{ $c['producto'] }}</td>
                <td>{{ $c['cantidad'] }}</td>
                <td>{{ $c['unitario'] }}</td>
                <td class="fw-bold">{{ $c['subtotal'] }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection

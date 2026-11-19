@extends('layouts.marketplace')

@section('contenido')
<h3 class="encabezado-vista fw-bold mb-4">Explorar Catalogo por Categoria y Region</h3>

@if(session('success'))
    <div class="alert alert-success fw-semibold shadow-sm">{{ session('success') }}</div>
@endif

@if($errors->any())
    <div class="alert alert-danger shadow-sm">
        <ul class="mb-0">
            @foreach($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif

<div class="bg-white p-4 border rounded shadow-sm mb-4">
    <h5 class="fw-bold mb-3">Catalogo Disponible</h5>
    <table class="table table-hover align-middle">
        <thead class="thead-branding">
            <tr>
                <th>Codigo</th>
                <th>Artesania</th>
                <th>Tienda</th>
                <th>Categoria</th>
                <th>Region</th>
                <th>Precio</th>
                <th>Stock</th>
                <th>Cantidad y Agregar</th>
            </tr>
        </thead>
        <tbody>
            @foreach($catalogo as $item)
            <tr>
                <td>{{ $item['codigo'] }}</td>
                <td class="fw-bold">{{ $item['nombre'] }}</td>
                <td>{{ $item['tienda'] }}</td>
                <td>{{ $item['categoria'] }}</td>
                <td><span class="badge badge-acento">{{ $item['region'] ?: 'Huánuco' }}</span></td>
                <td>{{ $item['precio'] }}</td>
                <td>{{ $item['stock'] }}</td>
                <td>
                    <form action="{{ route('comprador.carrito.agregar') }}" method="POST" class="d-flex align-items-center gap-2 m-0">
                        @csrf
                        <input type="hidden" name="producto_id" value="{{ $item['id'] }}">
                        <input
                            type="number"
                            name="cantidad"
                            value="1"
                            min="1"
                            max="{{ (int) $item['stock'] }}"
                            class="form-control form-control-sm"
                            style="width: 72px;"
                            required
                        >
                        <button type="submit" class="btn btn-sm btn-primario">Agregar</button>
                    </form>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>

<div class="bg-white p-4 border rounded shadow-sm">
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h5 class="fw-bold mb-0">Resumen de Mi Carrito de Compras</h5>
        <a href="{{ route('comprador.checkout') }}" class="btn btn-primario">Proceder al Pago y Valoración</a>
    </div>
    <table class="table align-middle">
        <thead class="thead-branding">
            <tr><th>Producto</th><th>Cantidad</th><th>Precio Unitario</th><th>Subtotal</th></tr>
        </thead>
        <tbody>
            @forelse($carrito as $c)
            <tr>
                <td>{{ $c['producto'] }}</td>
                <td>{{ $c['cantidad'] }}</td>
                <td>{{ $c['unitario'] }}</td>
                <td class="fw-bold">{{ $c['subtotal'] }}</td>
            </tr>
            @empty
            <tr>
                <td colspan="4" class="text-center text-muted py-3">Tu carrito está vacío. Agrega una artesanía arriba.</td>
            </tr>
            @endforelse
        </tbody>
    </table>
</div>
@endsection
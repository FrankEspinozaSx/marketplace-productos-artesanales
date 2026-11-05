@extends('layouts.marketplace')

@section('contenido')
<h3 class="encabezado-vista fw-bold mb-4">Panel de Metricas y Gestion de Pedidos</h3>

<div class="row g-3 mb-4">
    <div class="col-md-3"><div class="p-3 bg-white border rounded shadow-sm"><h6>Ventas del Mes</h6><h4 class="fw-bold">{{ $resumenMetricas['ventas_mes'] }}</h4></div></div>
    <div class="col-md-3"><div class="p-3 bg-white border rounded shadow-sm"><h6>Pedidos Pendientes</h6><h4 class="fw-bold">{{ $resumenMetricas['pedidos_pendientes'] }}</h4></div></div>
    <div class="col-md-3"><div class="p-3 bg-white border rounded shadow-sm"><h6>Productos Activos</h6><h4 class="fw-bold">{{ $resumenMetricas['productos_activos'] }}</h4></div></div>
    <div class="col-md-3"><div class="p-3 bg-white border rounded shadow-sm"><h6>Reputacion</h6><h4 class="fw-bold">{{ $resumenMetricas['calificacion'] }}</h4></div></div>
</div>

<div class="bg-white p-4 border rounded shadow-sm">
    <h5 class="fw-bold mb-3">Tabla de Pedidos Recibidos (Arreglo Estatico)</h5>
    <table class="table table-hover">
        <thead class="thead-branding">
            <tr><th>Codigo</th><th>Cliente</th><th>Producto</th><th>Cant.</th><th>Total</th><th>Estado</th></tr>
        </thead>
        <tbody>
            @foreach($pedidosRecibidos as $pedido)
            <tr>
                <td><strong>{{ $pedido['codigo'] }}</strong></td>
                <td>{{ $pedido['cliente'] }}</td>
                <td>{{ $pedido['producto'] }}</td>
                <td>{{ $pedido['cantidad'] }}</td>
                <td>{{ $pedido['total'] }}</td>
                <td><span class="badge badge-acento">{{ $pedido['estado'] }}</span></td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection

@extends('layouts.marketplace')

@section('contenido')
<h3 class="encabezado-vista fw-bold mb-4">Formulario de Pago Seguro y Valoracion de Compra</h3>

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

{{-- Resumen de Mi Carrito de Compras con Agregar, +/- y Eliminar --}}
<div class="bg-white p-4 border rounded shadow-sm mb-4">
    <h5 class="fw-bold mb-3">Resumen de Mi Carrito de Compras</h5>

    <form action="{{ route('comprador.carrito.agregar') }}" method="POST" class="row g-2 align-items-end mb-4 p-3 rounded border bg-light">
        @csrf
        <input type="hidden" name="redirect_to" value="checkout">

        <div class="col-md-7">
            <label class="form-label fw-semibold small mb-1">Agregar Producto al Carrito</label>
            <select name="producto_id" class="form-select form-select-sm" required>
                <option value="">Seleccione una artesanía...</option>
                @foreach($productos as $prod)
                    <option value="{{ $prod->id }}">
                        {{ $prod->nombre }} — S/ {{ number_format($prod->precio, 2) }} (Stock: {{ $prod->stock }})
                    </option>
                @endforeach
            </select>
        </div>

        <div class="col-md-2">
            <label class="form-label fw-semibold small mb-1">Cantidad</label>
            <input type="number" name="cantidad" value="1" min="1" class="form-control form-control-sm" required>
        </div>

        <div class="col-md-3">
            <button type="submit" class="btn btn-sm btn-primario w-100">+ Agregar al Carrito</button>
        </div>
    </form>

    @if(isset($carritoItems) && $carritoItems->count() > 0)
        <div class="table-responsive">
            <table class="table table-hover align-middle mb-2">
                <thead class="thead-branding">
                    <tr>
                        <th>Producto</th>
                        <th style="width: 170px;">Cantidad</th>
                        <th>Precio Unitario</th>
                        <th>Subtotal</th>
                        <th style="width: 110px;">Eliminar</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($carritoItems as $item)
                        <tr>
                            <td class="fw-bold">{{ $item['nombre'] }}</td>
                            <td>
                                <div class="d-flex align-items-center gap-1">
                                    <form action="{{ route('comprador.carrito.cantidad', $item['id']) }}" method="POST" class="m-0">
                                        @csrf
                                        @method('PATCH')
                                        <input type="hidden" name="accion" value="restar">
                                        <button type="submit" class="btn btn-sm btn-outline-secondary px-2 py-0" title="Restar">-</button>
                                    </form>

                                    <span class="px-2 fw-semibold">{{ $item['cantidad'] }}</span>

                                    <form action="{{ route('comprador.carrito.cantidad', $item['id']) }}" method="POST" class="m-0">
                                        @csrf
                                        @method('PATCH')
                                        <input type="hidden" name="accion" value="aumentar">
                                        <button type="submit" class="btn btn-sm btn-outline-secondary px-2 py-0" title="Aumentar">+</button>
                                    </form>
                                </div>
                            </td>
                            <td>S/ {{ number_format($item['precio'], 2) }}</td>
                            <td class="fw-bold">S/ {{ number_format($item['subtotal'], 2) }}</td>
                            <td>
                                <form action="{{ route('comprador.carrito.eliminar', $item['id']) }}" method="POST" class="m-0" onsubmit="return confirm('¿Quitar este producto del carrito?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-outline-danger">Eliminar</button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <div class="text-end fs-5 fw-bold mt-2">
            Total del Carrito: <span style="color: var(--color-primario);">S/ {{ number_format($totalCarrito ?? 0, 2) }}</span>
        </div>
    @else
        <p class="text-muted mb-0">Tu carrito está vacío. Usa el selector de arriba para agregar un producto.</p>
    @endif
</div>

{{-- Formulario de Pago y Valoración --}}
<div class="bg-white p-4 border rounded shadow-sm">
    <form action="{{ route('comprador.checkout.store') }}" method="POST">
        @csrf

        <div class="row g-3">
            <div class="col-md-6">
                <label class="form-label fw-semibold">Direccion de Entrega</label>
                <input
                    type="text"
                    name="direccion_envio"
                    class="form-control"
                    placeholder="Av. Universitaria 680 - Huanuco"
                    value="{{ old('direccion_envio') }}"
                    required
                >
            </div>

            <div class="col-md-6">
                <label class="form-label fw-semibold">Metodo de Pago</label>
                <select name="metodo_pago" id="metodo_pago" class="form-select" required>
                    <option value="Yape / Plin" {{ old('metodo_pago', 'Yape / Plin') === 'Yape / Plin' ? 'selected' : '' }}>
                        Yape / Plin
                    </option>
                    <option value="Tarjeta" {{ old('metodo_pago') === 'Tarjeta' ? 'selected' : '' }}>
                        Tarjeta (16 digitos)
                    </option>
                    <option value="Transferencia" {{ old('metodo_pago') === 'Transferencia' ? 'selected' : '' }}>
                        Transferencia Bancaria
                    </option>
                </select>
            </div>

            <div class="col-12" id="bloque-yape-plin">
                <div class="p-3 rounded border bg-light">
                    <div class="fw-bold mb-1" style="color: var(--color-secundario);">Pago con Yape / Plin</div>
                    <div class="small text-muted">
                        Realiza tu pago por Yape o Plin al taller en Huánuco y presiona <strong>Confirmar Pago y Enviar Valoracion</strong> para registrar tu pedido.
                    </div>
                </div>
            </div>

            <div class="col-md-6 d-none" id="bloque-tarjeta">
                <label class="form-label fw-semibold">Numero de Tarjeta (16 digitos)</label>
                <input
                    type="text"
                    name="numero_tarjeta"
                    class="form-control"
                    maxlength="19"
                    placeholder="4557880012345678"
                    value="{{ old('numero_tarjeta') }}"
                >
            </div>

            <div class="col-md-4">
                <label class="form-label fw-semibold">Calificacion al Artesano (1 a 5)</label>
                <input
                    type="number"
                    name="calificacion"
                    min="1"
                    max="5"
                    class="form-control"
                    value="{{ old('calificacion', 5) }}"
                >
            </div>

            <div class="col-md-8">
                <label class="form-label fw-semibold">Resena o Comentario del Producto</label>
                <input
                    type="text"
                    name="resena"
                    class="form-control"
                    placeholder="Excelente acabado del tejido artesanal..."
                    value="{{ old('resena') }}"
                >
            </div>
        </div>

        <div class="mt-4">
            <button type="submit" class="btn btn-primario">Confirmar Pago y Enviar Valoracion</button>
        </div>
    </form>
</div>

<script>
document.addEventListener('DOMContentLoaded', function () {
    const metodoSelect = document.getElementById('metodo_pago');
    const bloqueYape = document.getElementById('bloque-yape-plin');
    const bloqueTarjeta = document.getElementById('bloque-tarjeta');

    function actualizarMetodo() {
        const metodo = metodoSelect.value;
        bloqueYape.classList.toggle('d-none', metodo !== 'Yape / Plin');
        bloqueTarjeta.classList.toggle('d-none', metodo !== 'Tarjeta');
    }

    metodoSelect.addEventListener('change', actualizarMetodo);
    actualizarMetodo();
});
</script>
@endsection
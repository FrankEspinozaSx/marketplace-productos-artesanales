@extends('layouts.marketplace')

@section('contenido')
<h3 class="encabezado-vista fw-bold mb-4">Formulario de Pago Seguro y Valoracion de Compra</h3>

<div class="bg-white p-4 border rounded shadow-sm">
    <form method="POST" action="{{ route('comprador.checkout.store') }}">
        @csrf
        <div class="row g-3">
            <div class="col-md-6">
                <label class="form-label fw-semibold">Direccion de Entrega</label>
                <input type="text" name="direccion_envio" class="form-control @error('direccion_envio') is-invalid @enderror" value="{{ old('direccion_envio') }}" placeholder="Av. Universitaria 680 - Huanuco">
                @error('direccion_envio') <div class="invalid-feedback">{{ $message }}</div> @enderror
            </div>
            <div class="col-md-6">
                <label class="form-label fw-semibold">Numero de Tarjeta (16 digitos)</label>
                <input type="text" name="numero_tarjeta" class="form-control @error('numero_tarjeta') is-invalid @enderror" value="{{ old('numero_tarjeta') }}" placeholder="4557880012345678">
                @error('numero_tarjeta') <div class="invalid-feedback">{{ $message }}</div> @enderror
            </div>
            <div class="col-md-4">
                <label class="form-label fw-semibold">Calificacion al Artesano (1 a 5)</label>
                <input type="number" name="puntuacion" class="form-control @error('puntuacion') is-invalid @enderror" value="{{ old('puntuacion', 5) }}">
                @error('puntuacion') <div class="invalid-feedback">{{ $message }}</div> @enderror
            </div>
            <div class="col-md-8">
                <label class="form-label fw-semibold">Resena o Comentario del Producto</label>
                <input type="text" name="comentario" class="form-control @error('comentario') is-invalid @enderror" value="{{ old('comentario') }}" placeholder="Excelente acabado del tejido artesanal...">
                @error('comentario') <div class="invalid-feedback">{{ $message }}</div> @enderror
            </div>
        </div>
        <button type="submit" class="btn btn-primario mt-3">Confirmar Pago y Enviar Valoracion</button>
    </form>
</div>
@endsection

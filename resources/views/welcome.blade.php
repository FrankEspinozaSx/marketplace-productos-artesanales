@extends('layouts.marketplace')

@section('contenido')
<div class="p-5 bg-white rounded-3 border shadow-sm text-center">
    <span class="badge badge-acento mb-2 px-3 py-2">Comercio Justo y Cultura Local</span>
    <h1 class="fw-bold" style="color: var(--color-secundario);">4. Marketplace de Productos Artesanales</h1>
    <p class="lead">Conectamos artesanos y pequenos productores locales con compradores a nivel global.</p>

    @guest
        <div class="mt-4">
            <p class="text-muted">Inicia sesion o registrate para explorar el catalogo o administrar tu tienda artesanal.</p>
            <a href="{{ route('login') }}" class="btn btn-primario btn-lg me-2">Iniciar Sesion</a>
            <a href="{{ route('register') }}" class="btn btn-secundario btn-lg">Crear Cuenta</a>
        </div>
    @endguest

    @auth
        <div class="mt-4 p-4 rounded border" style="background-color: var(--color-fondo);">
            <h4>Â¡Bienvenido de nuevo, {{ auth()->user()->name }}!</h4>
            <p>Has ingresado con el perfil activo de <strong>{{ strtoupper(auth()->user()->rol) }}</strong>.</p>
            <a href="{{ route('dashboard') }}" class="btn btn-primario">Ir a mi Panel Principal</a>
        </div>
    @endauth
</div>
@endsection

@extends('layouts.marketplace')

@section('contenido')
<div class="p-5 bg-white rounded-3 border shadow-sm text-center">
    <span class="badge badge-acento mb-2 px-3 py-2">Comercio Justo y Cultura Local</span>
    <h1 class="fw-bold" style="color: var(--color-secundario);">Marketplace de Productos Artesanales Huanuqueño</h1>
    <p class="lead">Conectamos artesanos y pequeños productores locales con compradores a nivel nacional</p>

    @guest
        <div class="mt-4">
            <p class="text-muted">Inicia sesión o regístrate para explorar el catálogo</p>
            <a href="{{ route('login') }}" class="btn btn-primario btn-lg me-2">Iniciar Sesión</a>
            <a href="{{ route('register') }}" class="btn btn-secundario btn-lg">Crear Cuenta</a>
        </div>
    @endguest

    @auth
        <div class="mt-4 p-4 rounded border" style="background-color: var(--color-fondo);">
            <h4>¡Bienvenido de nuevo, {{ auth()->user()->name }}!</h4>
            <p>Has ingresado con el perfil activo de <strong>{{ strtoupper(auth()->user()->role) }}</strong>.</p>
            <a href="{{ route('dashboard') }}" class="btn btn-primario">Ir a mi Panel Principal</a>
        </div>
    @endauth
</div>
@endsection
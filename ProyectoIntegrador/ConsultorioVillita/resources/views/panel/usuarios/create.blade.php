@extends('layouts.app')

@section('title', 'Nuevo usuario')
@section('titulo', 'Nuevo usuario')
@section('subtitulo', 'Crea una cuenta de acceso al panel')

@section('content')
    <form method="POST" action="{{ route('panel.usuarios.store') }}">
        @csrf

        @include('panel.usuarios._form', ['usuario' => null])

        <div class="mt-6 flex flex-col-reverse gap-3 sm:flex-row sm:justify-end">
            <a href="{{ route('panel.usuarios.index') }}" class="btn-ghost justify-center">Cancelar</a>
            <button type="submit" class="btn-primary">
                <x-icon name="check" class="size-4" />
                Guardar usuario
            </button>
        </div>
    </form>
@endsection

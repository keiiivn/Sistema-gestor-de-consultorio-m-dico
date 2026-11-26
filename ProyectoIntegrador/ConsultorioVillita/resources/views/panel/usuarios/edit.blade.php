@extends('layouts.app')

@section('title', 'Editar usuario')
@section('titulo', 'Editar usuario')
@section('subtitulo', $usuario->nombre)

@section('content')
    <form method="POST" action="{{ route('panel.usuarios.update', $usuario) }}">
        @csrf
        @method('PUT')

        @include('panel.usuarios._form', ['usuario' => $usuario])

        <div class="mt-6 flex flex-col-reverse gap-3 sm:flex-row sm:justify-end">
            <a href="{{ route('panel.usuarios.index') }}" class="btn-ghost justify-center">Cancelar</a>
            <button type="submit" class="btn-primary">
                <x-icon name="check" class="size-4" />
                Actualizar usuario
            </button>
        </div>
    </form>
@endsection

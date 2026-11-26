@extends('layouts.app')

@section('title', 'Editar consulta')
@section('titulo', 'Editar consulta')
@section('subtitulo', $consulta->paciente?->nombre)

@section('content')
    <form method="POST" action="{{ route('panel.consultas.update', $consulta) }}">
        @csrf
        @method('PUT')

        @include('panel.consultas._form', ['consulta' => $consulta])

        <div class="mt-6 flex flex-col-reverse gap-3 sm:flex-row sm:justify-end">
            <a href="{{ route('panel.consultas.show', $consulta) }}" class="btn-ghost justify-center">Cancelar</a>
            <button type="submit" class="btn-primary">
                <x-icon name="check" class="size-4" />
                Actualizar consulta
            </button>
        </div>
    </form>
@endsection

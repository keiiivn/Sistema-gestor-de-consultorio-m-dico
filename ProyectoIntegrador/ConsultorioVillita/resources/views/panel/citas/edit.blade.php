@extends('layouts.app')

@section('title', 'Editar cita')
@section('titulo', 'Editar cita')
@section('subtitulo', $cita->paciente?->nombre)

@section('content')
    <form method="POST" action="{{ route('panel.citas.update', $cita) }}">
        @csrf
        @method('PUT')

        @include('panel.citas._form', ['cita' => $cita])

        <div class="mt-6 flex flex-col-reverse gap-3 sm:flex-row sm:justify-end">
            <a href="{{ route('panel.citas.show', $cita) }}" class="btn-ghost justify-center">Cancelar</a>
            <button type="submit" class="btn-primary">
                <x-icon name="check" class="size-4" />
                Actualizar cita
            </button>
        </div>
    </form>
@endsection

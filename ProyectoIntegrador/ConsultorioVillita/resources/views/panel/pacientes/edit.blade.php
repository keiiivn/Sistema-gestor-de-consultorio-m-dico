@extends('layouts.app')

@section('title', 'Editar paciente')
@section('titulo', 'Editar paciente')
@section('subtitulo', $paciente->nombre)

@section('content')
    <form method="POST" action="{{ route('panel.pacientes.update', $paciente) }}">
        @csrf
        @method('PUT')

        @include('panel.pacientes._form', ['paciente' => $paciente])

        <div class="mt-6 flex flex-col-reverse gap-3 sm:flex-row sm:justify-end">
            <a href="{{ route('panel.pacientes.show', $paciente) }}" class="btn-ghost justify-center">Cancelar</a>
            <button type="submit" class="btn-primary">
                <x-icon name="check" class="size-4" />
                Actualizar paciente
            </button>
        </div>
    </form>
@endsection

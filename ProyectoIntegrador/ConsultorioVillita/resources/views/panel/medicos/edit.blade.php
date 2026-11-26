@extends('layouts.app')

@section('title', 'Editar médico')
@section('titulo', 'Editar médico')
@section('subtitulo', $medico->nombre)

@section('content')
    <form method="POST" action="{{ route('panel.medicos.update', $medico) }}">
        @csrf
        @method('PUT')

        @include('panel.medicos._form', ['medico' => $medico])

        <div class="mt-6 flex flex-col-reverse gap-3 sm:flex-row sm:justify-end">
            <a href="{{ route('panel.medicos.show', $medico) }}" class="btn-ghost justify-center">Cancelar</a>
            <button type="submit" class="btn-primary">
                <x-icon name="check" class="size-4" />
                Actualizar médico
            </button>
        </div>
    </form>
@endsection

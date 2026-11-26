@extends('layouts.app')

@section('title', 'Nuevo paciente')
@section('titulo', 'Nuevo paciente')
@section('subtitulo', 'Registra a un nuevo paciente en el consultorio')

@section('content')
    <form method="POST" action="{{ route('panel.pacientes.store') }}">
        @csrf

        @include('panel.pacientes._form', ['paciente' => null])

        <div class="mt-6 flex flex-col-reverse gap-3 sm:flex-row sm:justify-end">
            <a href="{{ route('panel.pacientes.index') }}" class="btn-ghost justify-center">Cancelar</a>
            <button type="submit" class="btn-primary">
                <x-icon name="check" class="size-4" />
                Guardar paciente
            </button>
        </div>
    </form>
@endsection

@extends('layouts.app')

@section('title', 'Nuevo médico')
@section('titulo', 'Nuevo médico')
@section('subtitulo', 'Registra el perfil profesional de un médico')

@section('content')
    <form method="POST" action="{{ route('panel.medicos.store') }}">
        @csrf

        @include('panel.medicos._form', ['medico' => null])

        <div class="mt-6 flex flex-col-reverse gap-3 sm:flex-row sm:justify-end">
            <a href="{{ route('panel.medicos.index') }}" class="btn-ghost justify-center">Cancelar</a>
            <button type="submit" class="btn-primary">
                <x-icon name="check" class="size-4" />
                Guardar médico
            </button>
        </div>
    </form>
@endsection

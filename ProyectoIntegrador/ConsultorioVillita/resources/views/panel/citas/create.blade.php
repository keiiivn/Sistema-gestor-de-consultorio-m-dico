@extends('layouts.app')

@section('title', 'Nueva cita')
@section('titulo', 'Nueva cita')
@section('subtitulo', 'Agenda una cita para un paciente')

@section('content')
    <form method="POST" action="{{ route('panel.citas.store') }}">
        @csrf

        @include('panel.citas._form', ['cita' => null])

        <div class="mt-6 flex flex-col-reverse gap-3 sm:flex-row sm:justify-end">
            <a href="{{ route('panel.citas.index') }}" class="btn-ghost justify-center">Cancelar</a>
            <button type="submit" class="btn-primary">
                <x-icon name="check" class="size-4" />
                Guardar cita
            </button>
        </div>
    </form>
@endsection

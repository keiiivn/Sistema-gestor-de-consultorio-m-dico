@extends('layouts.app')

@section('title', 'Nueva consulta')
@section('titulo', 'Nueva consulta')
@section('subtitulo', 'Registra la atención médica de un paciente')

@section('content')
    <form method="POST" action="{{ route('panel.consultas.store') }}">
        @csrf

        @include('panel.consultas._form', ['consulta' => null])

        <div class="mt-6 flex flex-col-reverse gap-3 sm:flex-row sm:justify-end">
            <a href="{{ route('panel.consultas.index') }}" class="btn-ghost justify-center">Cancelar</a>
            <button type="submit" class="btn-primary">
                <x-icon name="check" class="size-4" />
                Guardar consulta
            </button>
        </div>
    </form>
@endsection

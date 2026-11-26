@extends('layouts.app')

@section('title', 'Nueva receta')
@section('titulo', 'Nueva receta')
@section('subtitulo', 'Genera una prescripción a partir de una consulta')

@section('content')
    <form method="POST" action="{{ route('panel.recetas.store') }}">
        @csrf

        @include('panel.recetas._form', ['receta' => null, 'idConsulta' => $idConsulta])

        <div class="mt-6 flex flex-col-reverse gap-3 sm:flex-row sm:justify-end">
            <a href="{{ route('panel.recetas.index') }}" class="btn-ghost justify-center">Cancelar</a>
            <button type="submit" class="btn-primary">
                <x-icon name="check" class="size-4" />
                Guardar receta
            </button>
        </div>
    </form>
@endsection

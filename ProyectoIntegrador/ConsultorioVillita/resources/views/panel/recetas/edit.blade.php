@extends('layouts.app')

@section('title', 'Editar receta')
@section('titulo', 'Editar receta')
@section('subtitulo', $receta->nombre_paciente)

@section('content')
    <form method="POST" action="{{ route('panel.recetas.update', $receta) }}">
        @csrf
        @method('PUT')

        @include('panel.recetas._form', ['receta' => $receta])

        <div class="mt-6 flex flex-col-reverse gap-3 sm:flex-row sm:justify-end">
            <a href="{{ route('panel.recetas.show', $receta) }}" class="btn-ghost justify-center">Cancelar</a>
            <button type="submit" class="btn-primary">
                <x-icon name="check" class="size-4" />
                Actualizar receta
            </button>
        </div>
    </form>
@endsection

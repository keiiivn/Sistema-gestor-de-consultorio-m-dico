@extends('layouts.app')

@section('title', 'Editar estudio')
@section('titulo', 'Editar estudio')
@section('subtitulo', $estudio->nombre_archivo)

@section('content')
    <form method="POST" action="{{ route('panel.estudios.update', $estudio) }}" enctype="multipart/form-data">
        @csrf
        @method('PUT')

        @include('panel.estudios._form', ['estudio' => $estudio])

        <div class="mt-6 flex flex-col-reverse gap-3 sm:flex-row sm:justify-end">
            <a href="{{ route('panel.estudios.show', $estudio) }}" class="btn-ghost justify-center">Cancelar</a>
            <button type="submit" class="btn-primary">
                <x-icon name="check" class="size-4" />
                Actualizar estudio
            </button>
        </div>
    </form>
@endsection

@extends('layouts.app')

@section('title', 'Subir estudio')
@section('titulo', 'Subir estudio')
@section('subtitulo', 'Adjunta un documento al expediente del paciente')

@section('content')
    <form method="POST" action="{{ route('panel.estudios.store') }}" enctype="multipart/form-data">
        @csrf

        @include('panel.estudios._form', ['estudio' => null, 'idPaciente' => $idPaciente])

        <div class="mt-6 flex flex-col-reverse gap-3 sm:flex-row sm:justify-end">
            <a href="{{ route('panel.estudios.index') }}" class="btn-ghost justify-center">Cancelar</a>
            <button type="submit" class="btn-primary">
                <x-icon name="check" class="size-4" />
                Subir estudio
            </button>
        </div>
    </form>
@endsection

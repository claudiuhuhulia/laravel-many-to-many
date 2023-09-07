@extends('layouts.app')
@section('title', 'Modifica Project')

@section('content')
    <header class="d-flex justify-content-between align-items center">
        <h1>Modifica Projetto</h1>
        <a class="btn btn-secondary my-3" href="{{ route('admin.projects.index') }}"><i
                class="fas fa-arrow-left me-2"></i>Torna
            indietro</a>
    </header>
    <hr>

    {{-- form --}}

    @include('includes.projects.form')

@endsection

@section('scripts')
    @Vite('resources/js/image-previewer.js')
    @Vite('resources/js/slug-generator.js')



@endsection

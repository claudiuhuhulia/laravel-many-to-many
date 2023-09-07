@extends('layouts.app')



@section('content')
    {{-- Header --}}
    <header class="d-flex align-items-center justify-content-between mt-5 mb-5">
        <h1>Cestino</h1>

        <form action="{{ route('admin.projects.dropAll') }}" method="POST">
            @csrf
            @method('DELETE')
            <button class="btn btn-danger">
                Svuota cestino
            </button>
        </form>

    </header>

    {{-- Content --}}

    <table class="table table-success" class="mt-5">
        <thead>
            <tr>
                <th scope="col">ID</th>
                <th scope="col">Nome</th>
                <th scope="col">Creato il</th>
                <th></th>
            </tr>
        </thead>
        <tbody>
            @forelse ($projects as $project)
                <tr>
                    <td scope="col">{{ $project->id }}</td>
                    <td scope="col">{{ $project->name }}</td>
                    <td scope="col">{{ $project->created_at }}</td>
                    <th scope="col" class="d-flex align-items-center justify-content-end">
                        {{-- Restore --}}
                        <form action="{{ route('admin.projects.restore', $project) }}" method="POST" class="me-2">
                            @csrf
                            @method('PATCH')
                            <button class="btn btn-success">
                                Restore
                            </button>
                        </form>

                        {{-- Delete --}}
                        <form action="{{ route('admin.projects.drop', $project) }}" method="POST">
                            @csrf
                            @method('DELETE')
                            <button class="btn btn-danger">
                                Delete
                            </button>
                        </form>
                    </th>
                </tr>
            @empty
                <tr>
                    <td colspan="4" class="text-center">Il cestino è vuoto</td>
                </tr>
            @endforelse
    </table>
    </ul>

    <a class="btn btn-secondary" href="{{ route('admin.projects.index') }}">Torna indietro</a>
@endsection

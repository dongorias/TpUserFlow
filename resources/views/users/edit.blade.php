@extends('dashboard')

@section('content')
    <div class="container-fluid">
        @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        <div class="card">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h4 class="mb-0">Liste des utilisateurs</h4>
                <a href="{{ route('users.create') }}" class="btn btn-primary">
                    <i class="bi bi-person-plus"></i> Ajouter utilisateur
                </a>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-striped table-hover">
                        <thead>
                        <tr>
                            <th>#</th>
                            <th>Nom</th>
                            <th>Prénom</th>
                            <th>Email</th>
                            <th>Observation</th>
                            <th>Date de Création</th>
                            <th>Actions</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($users as $user)
                            <tr>
                                <td>{{ $user->id }}</td>
                                <td>{{ $user->lastname }}</td>
                                <td>{{ $user->firstname }}</td>
                                <td>{{ $user->email }}</td>
                                <td>{{ $user->observation }}</td>
                                <td>{{ $user->created_at->format('d/m/Y') }}</td>
                                <td>
                                    <div class="btn-group" role="group">
                                        <a href="{{ route('users.edit', ['id'=>$user->id]) }}"
                                           class="btn btn-sm btn-warning me-2" >
                                            <i class="bi bi-pencil-square"></i>
                                        </a>

                                        <form action="{{route('users.destroy',['id'=>$user->id])}}" method="POST" class="d-inline">
                                            @csrf
                                            <button type="submit" class="btn btn-sm btn-danger"
                                                    onclick="return confirm('Êtes-vous sûr ?')">
                                                <i class="bi bi-trash"></i>
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                        </tbody>
                        {{--{{ $users->links() }}--}}
                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection

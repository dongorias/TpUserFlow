@extends('dashboard')

@section('content')
    <div class="container-fluid">
        <div class="row">

            <!-- Contenu principal -->
            <main role="main" class="col-md-9 ml-sm-auto col-lg-10 px-4">
                <div class="container-fluid">
                    @if(session('success'))
                        <div class="alert alert-success alert-dismissible fade show" role="alert">
                            {{ session('success') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    @endif

                    <div class="card">
                        <div class="card-header d-flex justify-content-between align-items-center">
                            <h4 class="mb-0">Liste des menus</h4>
                            <a href="{{ route('menus.create') }}" class="btn btn-primary">
                                <i class="bi bi-person-plus"></i> Ajouter menu
                            </a>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-striped table-hover">
                                    <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Ordre</th>
                                        <th>Intitule</th>
                                        <th>Open</th>
                                    </tr>
                                    </thead>
                                    <tbody wire:sortable="updateMenuOrder">

                                    @foreach($menus as $menu)
                                        <tr wire:sortable.item="{{ $menu->id }}" wire:key="menu-{{ $menu->id }}" wire:sortable.handle >
                                            <td>{{ $menu->id }}</td>
                                            <td>{{ $menu->ordre }}</td>
                                            <td>{{ $menu->intitule }}</td>
                                            <td><a href="{{url( $menu->lien) }}" target="_blank"><i class="bi bi-box-arrow-up-right"> </a></i></td>
                                            <td>
                                                <div class="btn-group" role="group">
                                                    <a href="{{ route('menus.edit', ['id'=>$menu->id]) }}"
                                                       class="btn btn-sm btn-warning me-1">
                                                        <i class="bi bi-pencil-square"></i>
                                                    </a>
                                                    <form action="{{route('menus.destroy',['id'=>$menu->id])}}" method="POST" class="d-inline">
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
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </main>
        </div>
    </div>

@endsection

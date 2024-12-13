@extends('dashboard')

@section('content')
    <div class="container-fluid">
        <div class="card">
            <div class="card-header">
                <div class="row align-items-center">
                    <div class="col-6">
                        <h4 class="mb-0">Ajouter un utilisateur</h4>
                    </div>
                    <div class="col-6 text-end">
                        <a href="{{route('users.index')}}" class="btn btn-sm btn-primary">
                            Retour
                        </a>
                    </div>
                </div>
            </div>

            <div class="card-body">
                <form action="{{ route('users.store') }}" method="POST">
                    @csrf
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="lastname" class="form-label">Nom</label>
                            <input type="text" class="form-control @error('lastname') is-invalid @enderror"
                                   id="lastname" name="lastname" value="{{ old('lastname') }}" required>
                            @error('lastname')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="firstname" class="form-label">Prénom</label>
                            <input type="text" class="form-control @error('firstname') is-invalid @enderror"
                                   id="firstname" name="firstname" value="{{ old('firstname') }}" required>
                            @error('firstname')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="email" class="form-label">Email</label>
                            <input type="email" class="form-control @error('email') is-invalid @enderror"
                                   id="email" name="email" value="{{ old('email') }}" required>
                            @error('email')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="password" class="form-label">Mot de passe</label>
                            <input type="password" class="form-control @error('password') is-invalid @enderror"
                                   id="password" name="password" value="{{ old('password') }}" required>
                            @error('password')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                    </div>
                    <div class="d-grid">
                        <button type="submit" class="btn btn-primary">
                            <i class="bi bi-person-plus"></i> Ajouter un utilisateur
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection

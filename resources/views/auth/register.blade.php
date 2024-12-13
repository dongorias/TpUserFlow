@extends('welcome')

@section('title', 'Inscription')

@section('content')
<div class="container">
    <div class="row justify-content-center align-items-center" style="height: 100vh;">
        <div class="col-md-6">
            <div class="card shadow-sm">
                <div class="card-body p-5">
                    <h2 class="text-center mb-4">Inscription</h2>

                    <form method="POST" action="{{ route('register.post') }}">
                        @csrf

                        <div class="mb-3">
                            <label for="lastname" class="form-label">Nom</label>
                            <input type="text"
                                   class="form-control @error('lastname') is-invalid @enderror"
                                   id="lastname"
                                   name="lastname"
                                   value="{{ old('lastname') }}"
                                   required
                                   autocomplete="lastname"
                                   autofocus>

                            @error('lastname')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="firstname" class="form-label">Prénom</label>
                            <input type="text"
                                   class="form-control @error('firstname') is-invalid @enderror"
                                   id="firstname"
                                   name="firstname"
                                   value="{{ old('firstname') }}"
                                   required
                                   autocomplete="firstname"
                                   autofocus>

                            @error('firstname')
                            <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="email" class="form-label">Email</label>
                            <input type="email"
                                   class="form-control @error('email') is-invalid @enderror"
                                   id="email"
                                   name="email"
                                   value="{{ old('email') }}"
                                   required
                                   autocomplete="email">

                            @error('email')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="password" class="form-label">Mot de passe</label>
                            <input type="password"
                                   class="form-control @error('password') is-invalid @enderror"
                                   id="password"
                                   name="password"
                                   required
                                   autocomplete="new-password">

                            @error('password')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="password-confirm" class="form-label">Confirmer le mot de passe</label>
                            <input type="password"
                                   class="form-control"
                                   id="password-confirm"
                                   name="password_confirmation"
                                   required
                                   autocomplete="new-password">
                        </div>

                        <div class="mb-3 form-check">
                            <input type="checkbox"
                                   class="form-check-input @error('terms') is-invalid @enderror"
                                   id="terms"
                                   name="terms"
                                   required>
                            <label class="form-check-label" for="terms">
                                J'accepte les conditions d'utilisation
                            </label>

                            @error('terms')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>

                        <div class="d-grid">
                            <button type="submit" class="btn btn-success">
                                S'inscrire
                            </button>
                        </div>

                        <div class="text-center mt-3">
                            <p>
                                Déjà un compte ?
                                <a href="{{ route('login') }}">Connectez-vous</a>
                            </p>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

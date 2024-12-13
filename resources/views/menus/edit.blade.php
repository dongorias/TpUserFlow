@extends('dashboard')

@section('content')
<div class="container-fluid">
    <div class="card">
        <div class="card-header">
            <div class="row align-items-center">
                <div class="col-6">
                    <h4 class="mb-0">Editer un menu</h4>
                </div>
                <div class="col-6 text-end">
                    <a href="{{route('menus.index')}}" class="btn btn-sm btn-primary">
                        Retour
                    </a>
                </div>
            </div>
        </div>

        <div class="card-body">
            <form action="{{ route('menus.update', ['id'=>$menu->id]) }}" method="POST">
                @csrf
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label for="intitule" class="form-label">Intitule</label>
                        <input type="text" class="form-control @error('intitule') is-invalid @enderror"
                               id="intitule" name="intitule" value="{{ $menu->intitule }}" required>
                        @error('intitule')
                        <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="col-md-6 mb-3">
                        <label for="lien" class="form-label">Lien</label>
                        <input type="text" class="form-control @error('lien') is-invalid @enderror"
                               id="lien" name="lien" value="{{ $menu->lien  }}" required>
                        @error('lien')
                        <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
                <div class="d-grid">
                    <button type="submit" class="btn btn-primary">
                        <i class="bi bi-person-plus"></i> Editer un menu
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

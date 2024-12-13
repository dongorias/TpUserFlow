@extends('dashboard')

@section('content')
    <div class="card mb-4">
        <div class="card-header bg-primary text-white">
            <h2 class="h5">Saisie quotidienne</h2>
        </div>
        <div class="card-body">
            <div class="row mb-3">
                <div class="col-md-6">
                    <label for="coucher" class="form-label">Heure de coucher</label>
                    <input type="time" class="form-control" id="coucher" name="coucher">
                </div>
                <div class="col-md-6">
                    <label for="lever" class="form-label">Heure de lever</label>
                    <input type="time" class="form-control" id="lever" name="lever">
                </div>
            </div>
            <div class="row mb-3">
                <div class="col-md-4">
                    <label for="sieste" class="form-label">Avez-vous fait une sieste ?</label>
                    <select class="form-select" id="sieste" name="sieste">
                        <option value="none">Non</option>
                        <option value="apres-midi">Oui, l'après-midi</option>
                        <option value="soir">Oui, en soirée</option>
                    </select>
                </div>
                <div class="col-md-4">
                    <label for="forme" class="form-label">État de forme (score 0-10)</label>
                    <select class="form-select" id="forme" name="forme">
                        <option value="0">0</option>
                        <option value="1">1</option>
                        <option value="2">2</option>
                        <option value="3">3</option>
                        <option value="4">4</option>
                        <option value="5">5</option>
                        <option value="6">6</option>
                        <option value="7">7</option>
                        <option value="8">8</option>
                        <option value="9">9</option>
                        <option value="10">10</option>
                    </select>
                </div>
                <div class="col-md-4">
                    <label for="sport" class="form-label">Avez-vous fait du sport ?</label>
                    <select class="form-select" id="sport" name="sport">
                        <option value="non">Non</option>
                        <option value="oui">Oui</option>
                    </select>
                </div>
            </div>
            <div class="mb-3">
                <label for="commentaire" class="form-label">Commentaire</label>
                <textarea class="form-control" id="commentaire" name="commentaire" rows="3"></textarea>
            </div>
            <div class="alert alert-info" id="cycles-indicateur" role="alert">
                Nombre de cycles complétés : <span id="cycles-value">0</span>
                <i class="bi bi-circle-fill text-secondary" id="cycles-status"></i>
            </div>
        </div>
    </div>
@endsection

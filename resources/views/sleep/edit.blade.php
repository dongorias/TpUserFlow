@php use Carbon\Carbon; @endphp
@extends('dashboard')

@section('content')
    <div class="card mb-4">
        <div class="card-header bg-primary text-white d-flex justify-content-between align-items-center">
            <h2 class="h5 mb-0">Saisie quotidienne du {{ $day }}</h2>
            <h2 class="h5 mb-0 text-end"><a style="color: white" href="{{route('sleep.index')}}">Retour</a></h2>
        </div>

        <div class="card-body">
            <form action="{{ route('sleep.update', ['day'=>$day]) }}" method="POST">
                @csrf
                @if(session('error'))
                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                        {{ session('error') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                @endif
                <div class="row mb-3">
                    <div class="col-md-6">
                        <label for="bed_time" class="form-label">Heure de coucher</label>
                        @php
                            $formattedBedTime = $sleepEntry->bed_time ? Carbon::createFromFormat('H:i:s', $sleepEntry->bed_time)->format('H:i'):null;
                        @endphp
                        <input type="time" class="form-control" id="bed_time" name="bed_time"
                               value="{{ $formattedBedTime }}" required>
                        @error('bed_time')
                        <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="col-md-6">
                        <label for="wake_time" class="form-label">Heure de lever</label>
                        @php

                            $formattedWakeTime = $formattedWakeTime = $sleepEntry->wake_time ?Carbon::createFromFormat('H:i:s', $sleepEntry->wake_time)->format('H:i'):null;
                        @endphp
                        <input type="time" class="form-control" id="wake_time" name="wake_time"
                               value="{{ $formattedWakeTime }}" required>
                        @error('wake_time')
                        <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
                <div class="row mb-3">
                    <div class="col-md-4">
                        <label for="sieste" class="form-label">Avez-vous fait une sieste ?</label>
                        <select class="form-select" id="sieste" name="sieste" required>
                            <option value="0" {{ $sleepEntry->sieste==0 ? 'selected' : '' }}>Non</option>
                            <option value="1" {{ $sleepEntry->sieste==1 ? 'selected' : '' }}>Oui, l'après-midi</option>
                            <option value="2" {{ $sleepEntry->sieste==2 ? 'selected' : '' }}>Oui, en soirée</option>
                        </select>
                        @error('sieste')
                        <div class="invalid-feedback">{{ $sieste }}</div>
                        @enderror
                    </div>
                    <div class="col-md-4">
                        <label for="forme" class="form-label">État de forme (score 0-10)</label>
                        <select class="form-select" id="morning_form" name="morning_form" required>
                            <option value="0" {{ $sleepEntry->morning_form==0 ? 'selected' : '' }}>0</option>
                            <option value="1" {{ $sleepEntry->morning_form==1 ? 'selected' : '' }}>1</option>
                            <option value="2" {{ $sleepEntry->morning_form==2 ? 'selected' : '' }}>2</option>
                            <option value="3" {{ $sleepEntry->morning_form==3 ? 'selected' : '' }}>3</option>
                            <option value="4" {{ $sleepEntry->morning_form==4 ? 'selected' : '' }}>4</option>
                            <option value="5" {{ $sleepEntry->morning_form==5 ? 'selected' : '' }}>5</option>
                            <option value="6" {{ $sleepEntry->morning_form==6 ? 'selected' : '' }}>6</option>
                            <option value="7" {{ $sleepEntry->morning_form==7 ? 'selected' : '' }}>7</option>
                            <option value="8" {{ $sleepEntry->morning_form==8 ? 'selected' : '' }}>8</option>
                            <option value="9" {{ $sleepEntry->morning_form==9 ? 'selected' : '' }}>9</option>
                            <option value="10" {{ $sleepEntry->morning_form==10 ? 'selected' : '' }}>10</option>
                        </select>
                        @error('morning_form')
                        <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="col-md-4">
                        <label for="sport" class="form-label">Avez-vous fait du sport ?</label>
                        <select class="form-select" id="sport" name="sport" required>
                            <option value="0" {{ $sleepEntry->sport==0 ? 'selected' : '' }}>Non</option>
                            <option value="1" {{ $sleepEntry->sport==1 ? 'selected' : '' }}>Oui</option>
                        </select>
                        @error('sport')
                        <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
                <div class="mb-3">
                    <label for="commentaire" class="form-label">Commentaire</label>
                    <textarea class="form-control" id="comment" name="comment" rows="3"
                              required>{{ $sleepEntry->comment }}</textarea>
                    @error('comment')
                    <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                <div class="d-grid">
                    <button type="submit" class="btn btn-primary">
                        <i class="bi bi-person-plus"></i> Enregistrez
                    </button>
                </div>
                <!--<div class="alert alert-info" id="cycles-indicateur" role="alert">
                    Nombre de cycles complétés : <span id="cycles-value">0</span>
                    <i class="bi bi-circle-fill text-secondary" id="cycles-status"></i>
                </div>-->
            </form>
        </div>
    </div>
@endsection

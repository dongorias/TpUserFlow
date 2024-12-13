@php use Carbon\Carbon; @endphp

@extends('dashboard')

@section('content')
    <div class="container my-5">
        @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
        @endif
        <h1 class="text-center mb-4">Suivi Sommeil et Bien-Être</h1>
        <div class="card shadow-sm">
            <div class="card-body">
                <div class="table-responsive">
                <table class="table table-bordered table-striped table-hover">
                    <thead class="table-dark">
                    <tr>
                        <th scope="col">Jour</th>
                        <th scope="col">Heure de Coucher</th>
                        <th scope="col">Heure de Lever</th>
                        <th scope="col">Cycles complétés</th>
                        <th scope="col">Sieste Après-midi</th>
                        <th scope="col">Sieste Soir</th>
                        <th scope="col">État Matinal</th>
                        <th scope="col">Sport</th>
                        <th scope="col">Commentaire</th>
                        <th scope="col">Actions</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach ($data['days'] as $day)
                        <tr>
                            <td><strong>{{ $day }}</strong></td>
                            <td>{{ $data['sleepEntries'][$day]->bed_time ?Carbon::createFromFormat('H:i:s', $data['sleepEntries'][$day]->bed_time)->format('H:i'): 'Non renseigné' }}</td>
                            <td>{{ $data['sleepEntries'][$day]->wake_time ?Carbon::createFromFormat('H:i:s', $data['sleepEntries'][$day]->wake_time)->format('H:i'): 'Non renseigné' }}</td>
                            <td>{{ $data['sleepEntries'][$day]->cycles_completed ?? 'Non renseigné' }}</td>
                            <td>{{ isset($data['sleepEntries'][$day]) && $data['sleepEntries'][$day]->sieste ==1? 'Oui' : 'Non' }}</td>
                            <td>{{ isset($data['sleepEntries'][$day]) && $data['sleepEntries'][$day]->sieste ==2? 'Oui' : 'Non' }}</td>
                            <td>{{ $data['sleepEntries'][$day]->morning_form ?? '-' }}/10</td>
                            <td>{{ isset($data['sleepEntries'][$day]) && $data['sleepEntries'][$day]->sport ==1? 'Oui' : 'Non' }}</td>
                            <td>{{ $data['sleepEntries'][$day]->comment ?? 'Aucun commentaire' }}</td>
                            <td>
                                <a href="{{ route('sleep.edit', $day) }}" class="btn btn-primary btn-sm">Modifier</a>
                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
                </div>
                <!-- Section hebdomadaire -->
                <div class="card mb-4">
                    <div class="card-header bg-success text-white">
                        <h2 class="h5">Synthèse hebdomadaire</h2>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-6">
                                <p>Total cycles de sommeil : <span id="total-cycles">{{ $data['totalCyle'] }}</span></p>
                                <div class="progress">
                                    <div class="progress-bar
                                    @if($data['totalCyle'] >= 42) bg-success
                                    @elseif($data['totalCyle'] >= (42 / 2)) bg-warning
                                    @else bg-danger
                                    @endif"
                                   aria-valuenow="{{ $data['totalCyle'] }}"  aria-valuemax="42" id="total-cycles-bar" style="width: {{ ($data['totalCyle'] *100)/42 }}%"></div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <p>Jours consécutifs avec au moins 5 cycles : <span id="jours-5-cycles">{{$data['maxConsecutive']}}</span></p>
                                <div class="progress">
                                    <div class="progress-bar
                                    @if($data['maxConsecutive'] >= 4) bg-success
                                    @elseif($data['maxConsecutive'] >= (4/2)) bg-warning
                                    @else bg-danger
                                    @endif"
                                         aria-valuenow="{{{$data['maxConsecutive']}}}"  aria-valuemax="4" id="total-cycles-bar" style="width: {{ ($data['maxConsecutive']*100)/4 }}%"></div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Graphiques -->
                <div class="card">
                    <div class="card-header bg-secondary text-white">
                        <h2 class="h5">Graphiques</h2>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-6">
                                <canvas id="graphique-cycles"></canvas>
                            </div>
                            <div class="col-md-6">
                                <canvas id="graphique-forme" class="mt-4"></canvas>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <canvas id="formScatter"></canvas>
                            </div>
                            <div class="col-md-6">
                                <canvas id="sleepHeatmap"></canvas>
                            </div>
                        </div>


                        {{--<canvas id="sleepHistogram" class="mt-4"></canvas>--}}
                        {{--<canvas id="cycleBoxplot" class="mt-4"></canvas>--}}
                        <canvas id="sleepHeatmap" class="mt-4"></canvas>


                    </div>
                </div>
            </div>
        </div>
    </div>
    <script>
        // Données passées depuis le contrôleur Laravel

        const days = ['Lundi', 'Mardi', 'Mercredi', 'Jeudi', 'Vendredi', 'Samedi', 'Dimanche'];

        const data = @json( $data);


        const ctx1 = document.getElementById('graphique-cycles').getContext('2d');
        const ctx2 = document.getElementById('graphique-forme').getContext('2d');
        const ctx3 = document.getElementById('formScatter').getContext('2d');
        const ctx4 = document.getElementById('sleepHeatmap').getContext('2d');

        let valueArray=[];

        for(let i = 0; i<data.cycleArray.length; i++){
            valueArray.push((Math.min(data.cycleArray[i], 5)*100)/5);
        }

        new Chart(ctx1, {
            type: 'bar',
            data: {
                labels: days,

                datasets: [{
                    label: 'Cycles de sommeil',
                    data: valueArray,
                    backgroundColor: valueArray.map(h => {
                        if(h>=66){
                            return 'rgba(75, 192, 192, 0.6)'
                        }else if(h>33 && h<66){
                            return 'rgb(251,232,16)'
                        }else{
                            return 'rgb(233,1,38)'
                        }
                    })
                    //backgroundColor: 'rgba(75, 192, 192, 0.6)'
                }],

            },

            options: {
                responsive: true,
              plugins:{
                  datalabels: {
                      anchor: 'end',
                      align: 'end',
                      formatter: (value) => `${value.toFixed(0)}%`,
                      color: function(context) {
                          return context.dataset.backgroundColor[context.dataIndex];
                      },
                      font: {
                          weight: 'bold',
                          size: 12
                      }
                  }
              },
                scales: {
                    y: {
                        ticks: {
                            stepSize: 33,
                            callback: function(value) {
                                return [0, 33, 66, 100].includes(value) ? value : null;
                            }
                        },
                        beginAtZero: true,
                        max:100,
                        title: {
                            display: true,
                            text: 'Pourcentage (%)'
                        },


                    }
                }
            },
            plugins: [ChartDataLabels]

        });

        new Chart(ctx2, {
            type: 'line',
            data: {
                labels: days,
                datasets: [{
                    label: 'État Matinal',
                    data: data.formArray,
                    borderColor: 'rgba(153, 102, 255, 1)',
                    tension: 0.3,
                    fill: false
                }]
            },
            options: {
                responsive: true
            }
        });

        new Chart(ctx3, {
            type: 'scatter',
            data: {
                datasets: [{
                    label: 'État Matinal vs. Durée de sommeil',
                    data: data.sleepHoursArray.map((dur, idx) => ({ x: dur, y: data.morningFormArray[idx] })),
                    backgroundColor: 'rgba(255, 159, 64, 0.6)'
                }]
            },
            options: {
                scales: {
                    x: {
                        title: {
                            display: true,
                            text: 'Durée de sommeil (h)'
                        }
                    },
                    y: {
                        title: {
                            display: true,
                            text: 'État Matinal'
                        }
                    }
                }
            }
        });

        new Chart(ctx4, {
            type: 'bar',
            data: {
                labels: days,
                datasets: [{
                    label: 'Durée de sommeil (h)',
                    data: data.sleepHoursArray,
                    backgroundColor: data.sleepHoursArray.map(h => h > 7 ? 'rgba(75, 192, 192, 0.6)' : 'rgba(255, 99, 132, 0.6)')
                }]
            },
            options: {
                plugins: {
                    tooltip: {
                        callbacks: {
                            label: context => `Durée: ${context.raw}h`
                        }
                    }
                }
            }
        });

    </script>

@endsection



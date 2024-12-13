<?php

namespace App\Http\Controllers;

use App\Models\Sleep;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

function calculateSleepCycles($bedTime, $wakeTime)
{
    // Convertir les heures de coucher et de réveil en minutes
    $bedTimeMinutes = strtotime($bedTime);
    $wakeTimeMinutes = strtotime($wakeTime);

    // Calculer la durée totale de sommeil en minutes
    $totalSleepMinutes = (strtotime($wakeTime) - strtotime($bedTime)) / 60;

    // Si le réveil est le lendemain, ajouter 24 heures
    if ($wakeTimeMinutes < $bedTimeMinutes) {
        $totalSleepMinutes += 24 * 60;
    }

    $sleepHours  = round($totalSleepMinutes / 60, 2);

    // Calculer le nombre de cycles (chaque cycle dure 120 minutes)
    $sleepCycles = round($totalSleepMinutes / 120, 2);
    //$sleepCycles = floor($totalSleepMinutes / 120);

    // Calculer le temps restant hors des cycles complets
    $remainingMinutes = $totalSleepMinutes % 120;

    return [
        'total_sleep_minutes' => round($totalSleepMinutes),
        'cycles_completed' => $sleepCycles,
        'sleep_hours' => $sleepHours,
        'remaining_minutes' => round($remainingMinutes)
    ];
}



class SleepController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // Récupérer les données existantes de la semaine pour l'utilisateur connecté
        $sleepEntries = Sleep::where('user_id', Auth::id())->get()->keyBy('day');

        // Jours de la semaine
        $days = ['Lundi', 'Mardi', 'Mercredi', 'Jeudi', 'Vendredi', 'Samedi', 'Dimanche'];


        $totalCyle = 0;
        $cycleArray = [];
        $formArray = [];
        $sleepHoursArray = [];
        $morningFormArray = [];
        $remainingMinutesArray = [];
        $currentConsecutive = 0;
        $maxConsecutive = 0;



        foreach ($sleepEntries as $element) {
            $totalCyle += $element->cycles_completed;
            $cycleArray[] = $element->cycles_completed;
            $sleepHoursArray[] = $element->sleep_hour;
            $morningFormArray[] = $element->morning_form;
            $remainingMinutesArray[] = $element->remaining_minutes;
            $formArray[] = $element->morning_form;
            if($element->cycles_completed>=5){
                //$cycleDaysStreak++;
                $currentConsecutive++;
                $maxConsecutive = max($maxConsecutive, $currentConsecutive);
            }else{
                $currentConsecutive = 0;
            }
        }

        $data =[
            'days' => $days,
            'sleepEntries' => $sleepEntries,
            'totalCyle' => $totalCyle,
            'maxConsecutive' => $maxConsecutive,
            'cycleArray' => $cycleArray,
            'formArray' => $formArray,
            'sleepHoursArray' => $sleepHoursArray,
            'morningFormArray' => $morningFormArray,
            'remainingMinutesArray' => $remainingMinutesArray
        ];

        return view('sleep.index', compact('data'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(Sleep $sleepEntry)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($day)
    {
        $sleepEntry = Sleep::firstOrNew(['user_id' => Auth::id(), 'day' => $day]);

        return view('sleep.edit', compact('sleepEntry', 'day'));
    }


    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $day)
    {
        try {

            $validated = $request->validate([
                'bed_time' => 'required|date_format:H:i',
                'wake_time' => 'required|date_format:H:i',
                'sieste' => 'required|integer|min:0|max:2',
                'morning_form' => 'required|integer|min:0|max:10',
                'sport' => 'nullable|boolean',
                'comment' => 'nullable|string',
            ]);

            // Calculer les cycles de sommeil
            $sleepAnalysis = calculateSleepCycles($validated['bed_time'], $validated['wake_time']);

            // Mettre à jour ou créer l'entrée
            Sleep::updateOrCreate(
                ['user_id' => Auth::id(), 'day' => $day],
                [
                    'bed_time' => $request->bed_time,
                    'wake_time' => $request->wake_time,
                    'sieste' => $request->sieste,
                    'morning_form' => $request->morning_form,
                    'sport' => $request->sport,
                    'comment' => $request->comment,
                    'sleep_hour' => $sleepAnalysis['sleep_hours'],
                    'cycles_completed' => $sleepAnalysis['cycles_completed'],
                    'remaining_minutes' => $sleepAnalysis['remaining_minutes']
                ]
            );

            return redirect()->route('sleep.index')->with('success', 'Données enregistrées avec succès.');
        } catch (\Exception $exception) {
            Log::warning('update error : ' . $exception->getMessage());
            return redirect()->route('sleep.edit', compact('day'))->withErrors($exception->getMessage());
        }

    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Sleep $sleepEntry)
    {
        //
    }


}

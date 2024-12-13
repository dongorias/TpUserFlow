<?php

namespace Database\Seeders;

use Faker\Factory as Faker;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {

        $faker = Faker::create('fr_FR');
        $jours = ['Lundi', 'Mardi', 'Mercredi', 'Jeudi', 'Vendredi', 'Samedi', 'Dimanche']; // Jours de la semaine en français


        $userId = '1';


        for ($i = 0; $i < 7; $i++) { // Une semaine de données pour chaque utilisateur
            $bedTime = $faker->time($format = 'H:i:s', $max = 'now');
            $wakeTime = $faker->time($format = 'H:i:s', $max = 'now');

            $bedTimestamp = strtotime($bedTime);
            $wakeTimestamp = strtotime($wakeTime);

            // Calculer la durée totale de sommeil
            $sleepDuration = $wakeTimestamp > $bedTimestamp
                ? ($wakeTimestamp - $bedTimestamp) / 3600
                : (24 - ($bedTimestamp - $wakeTimestamp) / 3600);

            $remainingMinutes = $faker->numberBetween(0, 120); // Ex. durée perdue à se rendormir
            $sieste = $faker->boolean ? $faker->numberBetween(0, 1) : 0; // Has sieste or not
            $cyclesCompleted = round($sleepDuration / 1.5, 2); // Approximativement 1 cycle = 1.5 heures
            $morningForm = $faker->numberBetween(1, 10); // Forme matinale sur 10
            $sport = $faker->boolean; // A-t-il pratiqué du sport ?

            DB::table('sleeps')->insert([
                'user_id' => $userId,
                'day' => $jours[$i],
                'bed_time' => $bedTime,
                'wake_time' => $wakeTime,
                'cycles_completed' => $cyclesCompleted,
                'sieste' => $sieste,
                'morning_form' => $morningForm,
                'sport' => $sport,
                'comment' => $faker->sentence,
                'created_at' => now(),
                'updated_at' => now(),
                'sleep_hour' => round($sleepDuration, 2),
                'remaining_minutes' => $remainingMinutes,
            ]);
        }
    }

}

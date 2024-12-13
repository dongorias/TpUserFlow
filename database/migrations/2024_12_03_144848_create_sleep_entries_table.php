<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('sleeps', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id'); // Liaison à un utilisateur
            $table->string('day'); // Nom du jour (lundi, mardi, etc.)
            $table->time('bed_time'); // Heure de coucher
            $table->time('wake_time'); // Heure de lever
            $table->integer('cycles_completed')->default(0); // nombre de cycle
            $table->integer('sieste')->default(0); // sieste value possible =>[0,1,2]
            $table->integer('morning_form'); // Score de forme 0-10
            $table->boolean('sport')->default(false); // Avez-vous fait du sport
            $table->text('comment')->nullable(); // Commentaire
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('sleeps');
    }
};

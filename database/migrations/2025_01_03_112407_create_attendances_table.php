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
    Schema::create('attendances', function (Blueprint $table) {
      $table->id();
      $table->timestamps();
      $table->date('start');
      $table->date('end');
      $table->enum('status', ['Ongoing', 'Completed'])->default('Ongoing');
      $table->integer('hours')->default(0);
      $table->integer('days')->default(0);
      $table->integer('presences')->default(0);

      $table->foreignId('participant_id')->constrained()->onDelete('cascade');
    });
  }

  /**
   * Reverse the migrations.
   */
  public function down(): void
  {
    Schema::dropIfExists('attendances');
  }
};

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
    Schema::create('participants', function (Blueprint $table) {
      $table->id();
      $table->timestamps();
      $table->string('phone')->nullable();
      $table->string('position');

      $table->foreignId('user_id')->unique()->constrained()->onDelete('cascade');
      $table->foreignId('mentor_id')->constrained()->onDelete('cascade');
      $table->foreignId('institution_id')->constrained()->onDelete('cascade');
    });
  }

  /**
   * Reverse the migrations.
   */
  public function down(): void
  {
    Schema::dropIfExists('participants');
  }
};

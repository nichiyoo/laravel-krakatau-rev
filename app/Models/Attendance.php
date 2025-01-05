<?php

namespace App\Models;

use App\Enums\AttendanceType;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Attendance extends Model
{
  use HasFactory;

  /**
   * The attributes that are mass assignable.
   *
   * @var array<string, mixed>
   */
  protected $fillable = [
    'start',
    'end',
    'status',
    'hours',
    'days',
    'presences',
  ];

  /**
   * Get the attributes that should be cast.
   *
   * @return array<string, string>
   */
  protected function casts(): array
  {
    return [
      'start' => 'date',
      'end' => 'date',
      'status' => AttendanceType::class,
    ];
  }

  /**
   * Return the relationship to the participant of the attendance.
   *
   * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
   */
  public function participant(): \Illuminate\Database\Eloquent\Relations\BelongsTo
  {
    return $this->belongsTo(Participant::class);
  }
}

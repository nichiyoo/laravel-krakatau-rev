<?php

namespace App\Models;

use Illuminate\Contracts\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Model;

class Participant extends Model
{
  use HasFactory;

  /**
   * The attributes that are mass assignable.
   *
   * @var array<string, mixed>
   */
  protected $fillable = [
    'phone',
    'position'
  ];

  /**
   * Get the user's first name.
   */
  protected function name(): Attribute
  {
    return Attribute::make(
      get: fn() => $this->user->name,
    );
  }

  /**
   * Query to filter participants that have no attendance.
   *
   * @param \Illuminate\Database\Eloquent\Builder $query
   * @return \Illuminate\Database\Eloquent\Builder
   */
  public function scopeNoAttendance(Builder $query): Builder
  {
    return $query->doesntHave('attendance');
  }

  /**
   * Query to filter participants that have no feedback.
   * 
   * @param \Illuminate\Database\Eloquent\Builder $query
   * @return \Illuminate\Database\Eloquent\Builder
   */
  public function scopeNoFeedback(Builder $query): Builder
  {
    return $query->doesntHave('feedback');
  }

  /**
   * Return the relationship to the institution of the participant.
   *
   * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
   */
  public function institution(): \Illuminate\Database\Eloquent\Relations\BelongsTo
  {
    return $this->belongsTo(Institution::class);
  }

  /**
   * Return the relationship to the mentor of the participant.
   *
   * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
   */
  public function mentor(): \Illuminate\Database\Eloquent\Relations\BelongsTo
  {
    return $this->belongsTo(Mentor::class);
  }

  /**
   * Return the relationship to the user of the participant.
   *
   * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
   */
  public function user(): \Illuminate\Database\Eloquent\Relations\BelongsTo
  {
    return $this->belongsTo(User::class);
  }

  /**
   * Return the relationship to the attendance of the participant.
   *
   * @return \Illuminate\Database\Eloquent\Relations\HasOne
   */
  public function attendance(): \Illuminate\Database\Eloquent\Relations\HasOne
  {
    return $this->hasOne(Attendance::class);
  }

  /**
   * Return the relationship to the feedback of the participant.
   *
   * @return \Illuminate\Database\Eloquent\Relations\HasMany
   */
  public function feedback(): \Illuminate\Database\Eloquent\Relations\HasOne
  {
    return $this->HasOne(Feedback::class);
  }

  /**
   * Return the relationship to the report of the participant.
   *
   * @return \Illuminate\Database\Eloquent\Relations\HasMany
   */
  public function reports(): \Illuminate\Database\Eloquent\Relations\HasMany
  {
    return $this->hasMany(Report::class);
  }
}

<?php

namespace App\Models;

use App\Enums\StatusType;
use Illuminate\Contracts\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Model;

class Mentor extends Model
{
  use HasFactory;

  /**
   * The attributes that are mass assignable.
   *
   * @var array<string, mixed>
   */
  protected $fillable = [
    'phone',
  ];

  /**
   * The relationships that should always be loaded.
   *
   * @var array<string>
   */
  protected $with = ['participants'];

  /**
   * Get the mentor status.
   */
  protected function status(): Attribute
  {
    return Attribute::make(
      get: fn() => $this->participants->count() >= 3 ? StatusType::Unavailable : StatusType::Available,
    );
  }

  /**
   * Query to filter mentors by participants count >= 3.
   *
   * @param \Illuminate\Database\Eloquent\Builder $query
   * @return \Illuminate\Database\Eloquent\Builder
   */
  public function scopeAvailable(Builder $query): Builder
  {
    return $query->has('participants', '<', 3);
  }

  /**
   * Return the relationship to the division of the mentor.
   *
   * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
   */
  public function division(): \Illuminate\Database\Eloquent\Relations\BelongsTo
  {
    return $this->belongsTo(Division::class);
  }

  /**
   * Return the relationship to the user of the mentor.
   *
   * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
   */
  public function user(): \Illuminate\Database\Eloquent\Relations\BelongsTo
  {
    return $this->belongsTo(User::class);
  }

  /**
   * Return the relationship to the participants of the mentor.
   *
   * @return \Illuminate\Database\Eloquent\Relations\HasMany
   */
  public function participants(): \Illuminate\Database\Eloquent\Relations\HasMany
  {
    return $this->hasMany(Participant::class);
  }

  /**
   * Return the relationship to the reports of the mentor.
   *
   * @return \Illuminate\Database\Eloquent\Relations\HasMany
   */
  public function reports(): \Illuminate\Database\Eloquent\Relations\HasMany
  {
    return $this->hasMany(Report::class);
  }
}

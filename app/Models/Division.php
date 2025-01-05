<?php

namespace App\Models;

use App\Enums\StatusType;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Casts\Attribute;


class Division extends Model
{
  use HasFactory;

  /**
   * The attributes that are mass assignable.
   *
   * @var array<string, mixed>
   */
  protected $fillable = [
    'name',
    'description',
    'capacity',
  ];

  /**
   * The relationships that should always be loaded.
   *
   * @var array<string>
   */
  protected $with = ['mentors', 'participants'];

  /**
   * Get the mentor status.
   */
  protected function status(): Attribute
  {
    return Attribute::make(
      get: function () {
        return $this->participants->count() >= $this->capacity  ? StatusType::Unavailable : StatusType::Available;
      },
    );
  }

  /**
   * Get the filled capacity of the division.
   */
  protected function filled(): Attribute
  {
    return Attribute::make(
      get: function () {
        return $this->participants->count();
      },
    );
  }

  /**
   * Return the relationship to the mentors of the division.
   *
   * @return \Illuminate\Database\Eloquent\Relations\HasMany
   */
  public function mentors(): \Illuminate\Database\Eloquent\Relations\HasMany
  {
    return $this->hasMany(Mentor::class);
  }

  /**
   * Return the relationship to the participants of the division.
   *
   * @return \Illuminate\Database\Eloquent\Relations\HasMany
   */
  public function participants(): \Illuminate\Database\Eloquent\Relations\HasManyThrough
  {
    return $this->HasManyThrough(Participant::class, Mentor::class);
  }
}

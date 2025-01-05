<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Institution extends Model
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
    'region',
    'city',
  ];

  /**
   * Return the relationship to the mentors of the institution.
   *
   * @return \Illuminate\Database\Eloquent\Relations\HasMany
   */
  public function participants(): \Illuminate\Database\Eloquent\Relations\HasMany
  {
    return $this->hasMany(Participant::class);
  }
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Feedback extends Model
{
  use HasFactory;

  /**
   * The attributes that are mass assignable.
   *
   * @var array
   */
  protected $fillable = [
    'feedback',
    'score',
  ];

  /**
   * Return the relationship to the participant of the feedback.
   *
   * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
   */
  public function participant(): \Illuminate\Database\Eloquent\Relations\BelongsTo
  {
    return $this->belongsTo(Participant::class);
  }
}

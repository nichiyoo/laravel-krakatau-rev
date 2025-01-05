<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Report extends Model
{
  use HasFactory;

  /**
   * The attributes that are mass assignable.
   *
   * @var array
   */
  protected $fillable = [
    'title',
    'description',
    'file',
  ];

  /**
   * Return the relationship to the participant of the report.
   *
   * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
   */
  public function participant(): \Illuminate\Database\Eloquent\Relations\BelongsTo
  {
    return $this->belongsTo(Participant::class);
  }
}

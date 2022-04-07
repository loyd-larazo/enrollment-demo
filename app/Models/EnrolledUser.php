<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EnrolledUser extends Model
{
  use HasFactory;

  protected $fillable = [
    'school_year_id',
    'user_id',
    'course_id',
    'year_level',
  ];
}

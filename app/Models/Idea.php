<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Idea extends Model
{
  use HasFactory; // Make sure this line is present
  // App\Models\Idea.php
  public function user()
  {
      return $this->belongsTo(User::class);
  }

  public function upvotes()
{
    return $this->hasMany(Upvote::class);
}

public function upvotesCount()
{
    return $this->upvotes()->count();
}



}

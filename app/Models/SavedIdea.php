<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SavedIdea extends Model
{
    public function idea()
    {
        return $this->belongsTo(Idea::class);
    }
}

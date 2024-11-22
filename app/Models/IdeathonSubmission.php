<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class IdeathonSubmission extends Model
{
    use HasFactory;

    protected $fillable = ['participant_id', 'submission_link', 'note', 'status'];

    public function participant()
    {
        return $this->belongsTo(IdeathonParticipant::class);
    }
}

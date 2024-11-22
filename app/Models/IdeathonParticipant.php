<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class IdeathonParticipant extends Model
{
    use HasFactory;

    protected $fillable = ['ideathon_id', 'user_id'];

    public function ideathon()
    {
        return $this->belongsTo(Ideathon::class);
    }

    public function submissions()
    {
        return $this->hasMany(IdeathonSubmission::class, 'participant_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}

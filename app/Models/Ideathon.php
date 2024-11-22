<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Ideathon extends Model
{
    use HasFactory;

    protected $fillable = [
        'company_id', 'title', 'description', 'requirement_links', 'tags', 'submission_deadline'
    ];

    protected $casts = [
        'requirement_links' => 'array',
        'tags' => 'array',
    ];

    public function participants()
    {
        return $this->hasMany(IdeathonParticipant::class);
    }

    public function company()
    {
        return $this->belongsTo(User::class, 'company_id');
    }
}

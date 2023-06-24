<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Chaper extends Model
{
    use HasFactory;
    protected $guarded = [];

    public function story() {
        return $this->belongsTo(Story::class, 'story_id');
    }
}

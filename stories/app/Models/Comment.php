<?php

namespace App\Models;

use Carbon\Carbon;
use Carbon\CarbonInterval;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{
    use HasFactory;
    protected $guarded = [];
    protected $appends = ['prefixed_created_at'];
    
    public function getPrefixedCreatedatAttribute()
    {
        return  Carbon::parse($this->attributes['created_at'])->diffForHumans();
    }
}

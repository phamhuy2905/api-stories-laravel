<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Story extends Model
{
    use HasFactory;
    protected $guarded = [];

    public function category() {
        return $this->belongsTo(Category::class, 'category_id');
    }
    public function publisher() {
        return $this->belongsTo(Publisher::class, 'publisher_id');
    }
  


    protected $appends = ['prefixed_thumbnail', 'prefixed_trailer'];
    
    public function getPrefixedThumbnailAttribute()
    {
        return 'http://127.0.0.1:8000/' . $this->attributes['thumbnail'];
    }
    public function getPrefixedTrailerAttribute()
    {
        return 'http://127.0.0.1:8000/' . $this->attributes['trailer'];
    }
}

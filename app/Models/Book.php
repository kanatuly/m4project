<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Book extends Model
{
    use HasFactory;
    protected $fillable = ['title', 'pages', 'author_id'];
    protected $with = ['photos'];
    public function author(){
        return $this->belongsTo('App\Models\Author', 'author_id');
    }
    public function photos()
    {
        return $this->hasMany('App\Models\Photo');
    }

}

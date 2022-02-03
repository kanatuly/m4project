<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Photo extends Model
{
    use HasFactory;
    //protected $with = [''];
    public function book(){
        return $this->belongsTo('App\Models\Book', 'book_id');
    }
    public function thumbnail()
    {
        return $this->hasOne('App\Models\Thumbnail');
    }
}

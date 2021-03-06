<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Author extends Model
{
    use HasFactory;
    protected $fillable = ['name', 'user_id'];
    protected $with = ['books'];

    public function books(){
        return $this->hasMany('App\Models\Book');
    }
}

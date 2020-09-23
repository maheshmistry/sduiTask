<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class News extends Model
{
    use HasFactory;

    // Creating the Model relationship between user and multiple news
    public function user(){
        return $this->belongsTo(User::class);
    }
}

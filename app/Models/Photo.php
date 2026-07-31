<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Photo extends Model
{
    public $fillable = ['user_id', 'category_id', 'title', 'image_path'];
}

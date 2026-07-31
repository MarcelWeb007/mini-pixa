<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    protected $fillable = [
        'name',
        'slug',
        'visible',
        'user_id',
    ];

    protected $casts = [
        'visible' => 'boolean',
    ];

    // Relation avec le créateur de la catégorie
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // Relation avec les photos de cette catégorie
    public function photos()
    {
        return $this->hasMany(Photo::class);
    }
}

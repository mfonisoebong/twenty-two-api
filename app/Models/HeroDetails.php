<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class HeroDetails extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'description',
        'image',
        'button_text',
        'button_link',
        'image_sm'
    ];
}

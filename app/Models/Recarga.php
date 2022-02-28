<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class recarga extends Model
{
    use HasFactory;
    protected $fillable = ['numero', 'cantidad', 'usuario'];
}

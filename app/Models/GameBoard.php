<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class GameBoard extends Model
{
    use HasFactory;
    protected $fillable = ['width', 'height', 'grid'];

    public function getGridAttribute($value)
    {
        return unserialize($value);
    }

    public function setGridAttribute($value)
    {
        $this->attributes['grid'] = serialize($value);
    }
}

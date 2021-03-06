<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Promocion extends Model
{
    use HasFactory;

    protected $fillable = [
        'mech_id', 'title', 'description', 'image','state'
    ];

    public function mecanica()
    {
        return $this->belongsTo(Mecanica::class);
    }
}

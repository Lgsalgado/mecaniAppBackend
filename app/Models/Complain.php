<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Complain extends Model
{
    use HasFactory;

    protected $fillable = [
        'mech_id', 'user_id', ' title', 'description', 'state','answer'
    ];
    public function user()
    {
        return $this->belongsTo(User::class);
    }
    public function mecanica()
    {
        return $this->belongsTo(Mecanica::class);
    }
}

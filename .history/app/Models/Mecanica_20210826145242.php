<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Mecanica extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id', 'name', 'address', 'phone', 'open_hour', 'certificate', 'close_hour',  'services', 'facebook', 'instagram', 'state'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function promociones()
    {
        return $this->hasMany(Promocion::class)
    }
}

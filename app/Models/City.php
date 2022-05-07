<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class City extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'state_id'
    ];

    public function state(): \Illuminate\Database\Eloquent\Relations\HasOne
    {
        return $this->hasOne(State::class, 'id', 'state_id');
    }
}

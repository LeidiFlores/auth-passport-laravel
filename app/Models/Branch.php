<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Branch extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'company_id',
        'address',
        'phone',
        'schedule',
        'is_web',
        'city_id'
    ];

    public function company(): \Illuminate\Database\Eloquent\Relations\HasOne
    {
        return $this->hasOne(Company::class, 'id', 'company_id');
    }

    public function city(): \Illuminate\Database\Eloquent\Relations\HasOne
    {
        return $this->hasOne(City::class, 'id', 'city_id');
    }
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class People extends Model
{
    use HasFactory;

    protected $fillable = [
        'first_name',
        'last_name',
        'document_number',
        'birth_date',
        'mobile_phone',
        'country_id',
        'document_type_id',
        'address'
    ];


    public function country(): \Illuminate\Database\Eloquent\Relations\HasOne
    {
        return $this->hasOne(Country::class, 'id', 'country_id');
    }

    public function document_type(): \Illuminate\Database\Eloquent\Relations\HasOne
    {
        return $this->hasOne(DocumentType::class, 'id', 'document_type_id');
    }

    /**
     * Nombre completo
     *
     * @return string
     */
    public function getFullName(): string
    {
        return ucfirst($this->first_name) . ' ' .
            ucfirst($this->last_name);
    }

    public function user(): \Illuminate\Database\Eloquent\Relations\HasOne
    {
        return $this->hasOne(User::class);
    }
}

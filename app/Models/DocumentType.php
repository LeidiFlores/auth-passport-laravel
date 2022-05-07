<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DocumentType extends Model
{
    use HasFactory;

    protected $fillable = [
        'name'
    ];

    public function peoples(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(DocumentType::class, 'document_type_id', 'id');
    }


}

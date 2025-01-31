<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Fournisseur extends Model
{
    use HasFactory;

    protected $fillable = ['nom', 'telephone', 'adresse'];

    public function purchases()
    {
        return $this->hasMany(Purchase::class);
    }

    public function scopeFilter($query, array $filters)
    {
        if (isset($filters['nom'])) {
            $query->where('nom', 'like', '%' . $filters['nom'] . '%');
        }

        if (isset($filters['telephone'])) {
            $query->where('telephone', 'like', '%' . $filters['telephone'] . '%');
        }

        if (isset($filters['adresse'])) {
            $query->where('adresse', 'like', '%' . $filters['adresse'] . '%');
        }
    }
}

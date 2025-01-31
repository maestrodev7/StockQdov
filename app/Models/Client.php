<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Client extends Model
{
    use HasFactory;

    protected $fillable = ['nom', 'telephone', 'adresse'];

    public function sales()
    {
        return $this->hasMany(Sale::class);
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


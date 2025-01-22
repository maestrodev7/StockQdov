<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Produit extends Model
{
    use HasFactory;

    protected $fillable = [
        'nom', 'description', 'prix_achat', 'prix_vente', 'categorie_id', 'date_peremption', 'type', 'quantite', 'magasin_id', 'boutique_id'
    ];

    public function scopeFilter($query, array $filters)
    {
        if (isset($filters['nom'])) {
            $query->where('nom', 'like', '%' . $filters['nom'] . '%');
        }
        if (isset($filters['categorie_id'])) {
            $query->where('categorie_id', $filters['categorie_id']);
        }  
        if (isset($filters['prix_achat_min'])) {
            $query->where('prix_achat', '>=', $filters['prix_achat_min']);
        }
        if (isset($filters['prix_achat_max'])) {
            $query->where('prix_achat', '<=', $filters['prix_achat_max']);
        }
        if (isset($filters['prix_vente_min'])) {
            $query->where('prix_vente', '>=', $filters['prix_vente_min']);
        }
        if (isset($filters['prix_vente_max'])) {
            $query->where('prix_vente', '<=', $filters['prix_vente_max']);
        }
        if (isset($filters['magasin_id'])) {
            $query->where('magasin_id', $filters['magasin_id']);
        }
        if (isset($filters['boutique_id'])) {
            $query->where('boutique_id', $filters['boutique_id']);
        }
    }

    public function purchases()
    {
        return $this->hasMany(Purchase::class);
    }

    public function sales()
    {
        return $this->hasMany(Sale::class);
    }

}

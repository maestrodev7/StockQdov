<?php

namespace App\Repositories;

use App\Models\Produit;
use App\Interfaces\ProduitRepositoryInterface;

class ProduitRepository implements ProduitRepositoryInterface
{

    public function scopeFilter( $filters)
    {
        $query = \App\Models\Produit::query();
        if (isset($filters['nom']) && !empty($filters['nom'])) {
            $query->where('nom', 'LIKE', '%' . $filters['nom'] . '%');
        }
        if (isset($filters['categorie_id']) && !empty($filters['categorie_id'])) {
            $query->where('categorie_id', $filters['categorie_id']);
        }
        if (isset($filters['magasin_id']) && !empty($filters['magasin_id'])) {
            $query->where('magasin_id', $filters['magasin_id']);
        }
        if (isset($filters['boutique_id']) && !empty($filters['boutique_id'])) {
            $query->where('boutique_id', $filters['boutique_id']);
        }
        return $query;
    }

    public function create(array $data)
    {
        return Produit::create($data);
    }

    public function decrementStock($magasinId, $quantite)
    {
        $produit = Produit::where('magasin_id', $magasinId)->firstOrFail();

        if ($produit->quantite < $quantite) {
            throw new \Exception('Quantité insuffisante dans le magasin.');
        }

        $produit->quantite -= $quantite;
        $produit->save();

        return $produit;
    }

    public function getByBoutique($boutiqueId, array $filters = [])
    {
        return Produit::filter($filters)->where('boutique_id', $boutiqueId)->get();
    }

    public function getByMagasin($magasinId, array $filters = [])
    {
        return Produit::filter($filters)->where('magasin_id', $magasinId)->get();
    }

    public function getProduitById($id)
    {
        return Produit::findOrFail($id);
    }

    public function update($id, array $data)
    {
        $produit = Produit::findOrFail($id);
        $produit->update($data);
        return $produit;
    }

    public function delete($id)
    {
        $produit = Produit::findOrFail($id);
        $produit->delete();
        return true;
    }
}

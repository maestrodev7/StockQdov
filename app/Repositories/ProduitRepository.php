<?php

namespace App\Repositories;

use App\Models\Produit;
use App\Interfaces\ProduitRepositoryInterface;

class ProduitRepository implements ProduitRepositoryInterface
{
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
<?php

namespace App\Repositories;

use App\Models\Taille_produits;
use App\Interfaces\TailleProduitRepositoryInterface;

class TailleProduitRepository implements TailleProduitRepositoryInterface
{
    public function __construct(protected Taille_produits $model)
    {
    }

    public function all()
    {
        return $this->model->all();
    }

    public function find($id)
    {
        return $this->model->find($id);
    }

    public function create(array $data)
    {
        return $this->model->create($data);
    }

    public function update($id, array $data)
    {
        $tailleProduit = $this->model->find($id);
        if ($tailleProduit) {
            $tailleProduit->update($data);
            return $tailleProduit;
        }
        return null;
    }

    public function delete($id)
    {
        $tailleProduit = $this->model->find($id);
        if ($tailleProduit) {
            return $tailleProduit->delete();
        }
        return false;
    }

    public function getByProduitId($produitId)
    {
        return $this->model->where('produit_id', $produitId)->get();
    }
}

<?php
namespace App\Interfaces;

interface ProduitRepositoryInterface
{
    public function create(array $data);
    public function decrementStock($magasinId, $quantite);
    public function getByBoutique($boutiqueId, array $filters = []);
    public function getByMagasin($magasinId, array $filters = []);
    public function getProduitByBoutique($boutiqueId, $id);
    public function getProduitByMagasin($magasinId, $id);
    public function update($id, array $data);
    public function delete($id);
}

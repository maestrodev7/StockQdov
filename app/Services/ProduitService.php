<?php
namespace App\Services;

use App\Interfaces\ProduitRepositoryInterface;

class ProduitService
{
    protected $produitRepository;

    public function __construct(ProduitRepositoryInterface $produitRepository)
    {
        $this->produitRepository = $produitRepository;
    }

    public function ajouterAuMagasin($data)
    {
        return $this->produitRepository->create($data);
    }

    public function ajouterALaBoutique($data)
    {
        if ($data['from_magazin']) {
            $this->produitRepository->decrementStock($data['magasin_id'], $data['quantite']);
        }

        return $this->produitRepository->create($data);
    }

    public function getByBoutique($boutiqueId, $filters = [])
    {
        return $this->produitRepository->getByBoutique($boutiqueId, $filters);
    }

    public function getByMagasin($magasinId, $filters = [])
    {
        return $this->produitRepository->getByMagasin($magasinId, $filters);
    }

    public function getProduitById($id)
    {
        return $this->produitRepository->getProduitById($id);
    }

    public function update($id, array $data)
    {
        return $this->produitRepository->update($id, $data);
    }

    public function delete($id)
    {
        return $this->produitRepository->delete($id);
    }
}

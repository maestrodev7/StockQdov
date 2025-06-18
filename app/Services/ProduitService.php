<?php
namespace App\Services;

use App\Interfaces\ProduitRepositoryInterface;
use App\Interfaces\CategorieRepositoryInterface;

class ProduitService
{
    protected $produitRepository;
    protected $categorieRepository;

    public function __construct(
        ProduitRepositoryInterface $produitRepository,
        CategorieRepositoryInterface $categorieRepository
    ) {
        $this->produitRepository = $produitRepository;
        $this->categorieRepository = $categorieRepository;
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
        $result = $this->produitRepository->getByBoutique($boutiqueId, $filters);
        return $this->formatPaginatedResponse($result);
    }

    public function getByMagasin($magasinId, $filters = [])
    {
        $result = $this->produitRepository->getByMagasin($magasinId, $filters);
        return $this->formatPaginatedResponse($result);
    }

    public function getAllPaginated(array $filters = [])
    {
        $result = $this->produitRepository->getAllPaginated($filters);
        return $this->formatPaginatedResponse($result);
    }

    public function getProduitById($id)
    {
        $produit = $this->produitRepository->getProduitById($id);
        return $this->attachCategorie($produit);
    }

    private function formatPaginatedResponse($paginator)
    {
        $produits = $paginator->items();
        $categories = $this->categorieRepository->getAllCategories()->keyBy('id');

        foreach ($produits as $produit) {
            $produit->categorie = $categories->get($produit->categorie_id);
        }

        return [
            'data' => $produits,
            'meta' => [
                'total' => $paginator->total(),
                'per_page' => $paginator->perPage(),
                'current_page' => $paginator->currentPage(),
                'last_page' => $paginator->lastPage(),
            ],
        ];
    }

    private function attachCategorie(&$produit)
    {
        if ($produit && $produit->categorie_id) {
            $categorie = $this->categorieRepository->getAllCategories()->firstWhere('id', $produit->categorie_id);
            $produit->categorie = $categorie;
        }
    }

    public function update($id, array $data)
    {
        return $this->produitRepository->update($id, $data);
    }

    public function delete($id)
    {
        return $this->produitRepository->delete($id);
    }

    public function incrementStock($produitId, $quantite)
    {
        return $this->produitRepository->incrementStock($produitId, $quantite);
    }

    public function decrementStock($produitId, $quantite)
    {
        return $this->produitRepository->decrementStock($produitId, $quantite);
    }
}

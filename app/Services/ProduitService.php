<?php
namespace App\Services;

use App\Interfaces\ProduitRepositoryInterface;
use App\Interfaces\CategorieRepositoryInterface;
use App\Interfaces\TailleProduitRepositoryInterface;


class ProduitService
{

    public function __construct(
        protected ProduitRepositoryInterface $produitRepository,
        protected CategorieRepositoryInterface $categorieRepository,
        protected TailleProduitRepositoryInterface $tailleProduitRepository
    )
    {
    }

    public function ajouterAuMagasin($data)
    {
        $produit = $this->produitRepository->create($data);

        if (!empty($data['tailles']) && is_array($data['tailles'])) {
            foreach ($data['tailles'] as $taille) {
                $this->tailleProduitRepository->create([
                    'produit_id' => $produit->id,
                    'taille' => $taille['taille'],
                    'prix_achat' => $taille['prix_achat'],
                    'prix_vente' => $taille['prix_vente'],
                    'quantite' => $taille['quantite'],
                ]);
            }
        }

        return $produit;
    }

    public function ajouterALaBoutique($data)
    {

        $produit = $this->produitRepository->create($data);

        if (!empty($data['tailles']) && is_array($data['tailles'])) {
            foreach ($data['tailles'] as $taille) {
                $this->tailleProduitRepository->create([
                    'produit_id' => $produit->id,
                    'taille' => $taille['taille'],
                    'prix_achat' => $taille['prix_achat'],
                    'prix_vente' => $taille['prix_vente'],
                    'quantite' => $taille['quantite'],
                ]);
            }
        }

        return $produit;
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
        $this->attachCategorie($produit);
        $produit->tailles = $this->tailleProduitRepository->getByProduitId($produit->id);
        return $produit;
    }

    private function formatPaginatedResponse($paginator)
    {
        $produits = $paginator->items();
        $categories = $this->categorieRepository->getAllCategories()->keyBy('id');

        foreach ($produits as $produit) {
            $produit->categorie = $categories->get($produit->categorie_id);
            $produit->tailles = $this->tailleProduitRepository->getByProduitId($produit->id);
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

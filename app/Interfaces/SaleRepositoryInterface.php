<?php
namespace App\Interfaces;

use App\Models\Sale;

interface SaleRepositoryInterface
{
    /**
     * Crée une vente avec les données fournies.
     *
     * @param array $data
     * @return Sale[]
     */
    public function createSale(array $data);

    /**
     * Récupère une vente par son identifiant.
     *
     * @param int $saleId
     * @return Sale
     */
    public function getSaleById(int $saleId);

    /**
     * Filtre les ventes en fonction des critères donnés.
     *
     * @param array $filters
     * @return \Illuminate\Support\Collection
     */
    public function filterSales(array $filters);

    /**
     * Met à jour une vente existante.
     *
     * @param int $saleId
     * @param array $data
     * @return Sale
     */
    public function updateSale(int $saleId, array $data);

    /**
     * Supprime une vente par son identifiant.
     *
     * @param int $saleId
     * @return bool
     */
    public function deleteSale(int $saleId);
}

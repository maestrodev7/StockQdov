<?php

namespace App\Interfaces;

interface PurchaseRepositoryInterface
{
    public function createPurchase(array $data);
    public function getPurchaseById(int $purchaseId);
    public function filterPurchases(array $filters);
    public function updatePurchase(int $purchaseId, array $data);
    public function deletePurchase(int $purchaseId);

}

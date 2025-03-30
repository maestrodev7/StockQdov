<?php

namespace App\Repositories;

use App\Models\Purchase;
use App\Interfaces\PurchaseRepositoryInterface;

class PurchaseRepository implements PurchaseRepositoryInterface
{
    public function createPurchase(array $data)
    {
        return Purchase::create($data);
    }


    public function getPurchaseById(int $purchaseId)
    {
        return Purchase::findOrFail($purchaseId);
    }

    public function updatePurchase(int $purchaseId, array $data)
    {
        $purchase = $this->getPurchaseById($purchaseId);
        $purchase->update($data);
        return $purchase;
    }

    public function deletePurchase(int $purchaseId)
    {
        $purchase = $this->getPurchaseById($purchaseId);
        return $purchase->delete();
    }

    public function filterPurchases(array $filters)
    {
        $query = Purchase::query();

        if (!empty($filters['start_date']) && !empty($filters['end_date'])) {
            $query->whereBetween('created_at', [$filters['start_date'], $filters['end_date']]);
        }

        if (!empty($filters['supplier_id'])) {
            $query->where('supplier_id', $filters['supplier_id']);
        }

        if (!empty($filters['product_id'])) {
            $query->where('product_id', $filters['product_id']);
        }

        if (!empty($filters['min_total_price'])) {
            $query->where('total_price', '>=', $filters['min_total_price']);
        }

        if (!empty($filters['max_total_price'])) {
            $query->where('total_price', '<=', $filters['max_total_price']);
        }

        return $query->get();
    }
}

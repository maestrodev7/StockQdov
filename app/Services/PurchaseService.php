<?php

namespace App\Services;

use App\Interfaces\PurchaseRepositoryInterface;
use App\Services\ProduitService;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

use Exception;

class PurchaseService
{
    protected $purchaseRepository;
    protected $produitService;

    public function __construct(
        PurchaseRepositoryInterface $purchaseRepository,
        ProduitService $produitService
    ) {
        $this->purchaseRepository = $purchaseRepository;
        $this->produitService = $produitService;
    }

    public function createPurchase(array $data)
    {
        DB::beginTransaction();

        try {
            $purchases = [];

            foreach ($data['items'] as $item) {
                $product = $this->produitService->getProduitById($item['product_id']);

                $totalPrice = $item['prix_achat'] * $item['quantite'];

                $purchase = $this->purchaseRepository->createPurchase([
                    'supplier_id' => $data['supplier_id'],
                    'product_id'  => $item['product_id'],
                    'quantity'    => $item['quantite'],
                    'price'       => $item['prix_achat'],
                    'total_price' => $totalPrice,
                ]);

                // ✅ Incrémenter le stock
                $this->produitService->incrementStock($product->id, $item['quantite']);

                $purchases[] = $purchase;
            }

            DB::commit();
            return $purchases;
        } catch (Exception $e) {
            DB::rollBack();
            throw $e;
        }
    }

    public function getPurchaseById(int $purchaseId)
    {
        return $this->purchaseRepository->getPurchaseById($purchaseId);
    }

    public function filterPurchases(array $filters)
    {
        return $this->purchaseRepository->filterPurchases($filters);
    }

    public function updatePurchase(int $purchaseId, array $data)
    {
        DB::beginTransaction();

        try {
            $purchase = $this->getPurchaseById($purchaseId);
        } catch (ModelNotFoundException $e) {
            throw new NotFoundHttpException("Achat avec l'ID {$purchaseId} introuvable.");
        }

        try {
            $product = $this->produitService->getProduitById($purchase->product_id);
        } catch (ModelNotFoundException $e) {
            throw new NotFoundHttpException("Produit lié à l'achat introuvable (ID : {$purchase->product_id}).");
        }

        try {
            $oldQuantity = $purchase->quantity;
            $newQuantity = $data['quantity'] ?? $oldQuantity;
            $difference = $newQuantity - $oldQuantity;

            $updatedPurchase = $this->purchaseRepository->updatePurchase($purchaseId, $data);

            if ($difference !== 0) {
                if ($difference > 0) {
                    $this->produitService->incrementStock($product->id, $difference);
                } else {
                    $this->produitService->decrementStock($product->id, abs($difference));
                }
            }

            DB::commit();
            return $updatedPurchase;
        } catch (NotFoundHttpException $e) {
            DB::rollBack();
            abort(404, $e->getMessage());
        } catch (Exception $e) {
            DB::rollBack();
            throw $e;
        }
    }


    public function deletePurchase(int $purchaseId)
    {
        DB::beginTransaction();

        try {
            $purchase = $this->getPurchaseById($purchaseId);
            $product = $this->produitService->getProduitById($purchase->product_id);

            // ✅ Décrémenter le stock (on annule l’ajout de l’achat)
            $this->produitService->decrementStock($product->id, $purchase->quantity);

            $result = $this->purchaseRepository->deletePurchase($purchaseId);

            DB::commit();
            return $result;
        } catch (Exception $e) {
            DB::rollBack();
            throw $e;
        }
    }
}

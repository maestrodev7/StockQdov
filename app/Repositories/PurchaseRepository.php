<?php

namespace App\Repositories;

use App\Models\Purchase;
use App\Models\Produit;
use App\Interfaces\PurchaseRepositoryInterface;
use Illuminate\Support\Facades\DB;

class PurchaseRepository implements PurchaseRepositoryInterface
{
    public function createPurchase(array $data)
    {
        DB::beginTransaction();

        try {
            $purchases = []; 

            foreach ($data['items'] as $item) {
                $product = Produit::findOrFail($item['product_id']); 

                $totalPrice = $item['prix_achat'] * $item['quantite'];

                $purchase = Purchase::create([
                    'supplier_id' => $data['supplier_id'], 
                    'product_id' => $item['product_id'],
                    'quantity' => $item['quantite'],
                    'price' => $item['prix_achat'],
                    'total_price' => $totalPrice,
                ]);

                $product->increment('quantite', $item['quantite']); 

                $purchases[] = $purchase;
            }

            DB::commit();

            return $purchases; 
        } catch (\Exception $e) {
            DB::rollBack(); 
            throw $e; 
        }
    }
}

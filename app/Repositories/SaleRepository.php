<?php
namespace App\Repositories;

use App\Models\Sale;
use App\Models\Produit;
use App\Interfaces\SaleRepositoryInterface;
use Illuminate\Support\Facades\DB;
use Exception;

class SaleRepository implements SaleRepositoryInterface
{
    public function createSale(array $data)
    {
        DB::beginTransaction(); 

        try {
            $sales = []; 

            foreach ($data['items'] as $item) {
                $product = Produit::findOrFail($item['product_id']); 

                if ($product->quantite < $item['quantite']) { 
                    throw new Exception("Not enough stock available for product ID {$item['product_id']}.");
                }

                $totalPrice = $item['prix_vente'] * $item['quantite'];

                $sale = Sale::create([
                    'client_id' => $data['client_id'], 
                    'product_id' => $item['product_id'],
                    'quantity' => $item['quantite'],
                    'price' => $item['prix_vente'],
                    'total_price' => $totalPrice,
                ]);

                $product->decrement('quantite', $item['quantite']); 

                $sales[] = $sale;
            }

            DB::commit(); 
            return $sales;
        } catch (Exception $e) {
            DB::rollBack(); 
            throw $e; 
        }
    }
}

<?php
namespace App\Repositories;

use App\Models\Sale;
use App\Models\Produit;
use App\Interfaces\SaleRepositoryInterface;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\ModelNotFoundException;
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
                    'client_id'   => $data['client_id'],
                    'product_id'  => $item['product_id'],
                    'quantity'    => $item['quantite'],
                    'price'       => $item['prix_vente'],
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

    public function getSaleById(int $saleId)
    {
        try {
            return Sale::findOrFail($saleId);
        } catch (ModelNotFoundException $e) {
            abort(404, 'Sale not found.');
        }
    }


    public function filterSales(array $filters)
    {
        $query = Sale::query();

        if (!empty($filters['start_date']) && !empty($filters['end_date'])) {
            $query->whereBetween('created_at', [$filters['start_date'], $filters['end_date']]);
        }

        if (!empty($filters['client_id'])) {
            $query->where('client_id', $filters['client_id']);
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

    public function updateSale(int $saleId, array $data)
    {
        DB::beginTransaction();

        try {
            $sale = $this->getSaleById($saleId);

            $sale->update($data);
            DB::commit();
            return $sale;
        } catch (Exception $e) {
            DB::rollBack();
            throw $e;
        }
    }

    public function deleteSale(int $saleId)
    {
        DB::beginTransaction();

        try {
            $sale = $this->getSaleById($saleId);
            $result = $sale->delete();
            DB::commit();
            return $result;
        } catch (Exception $e) {
            DB::rollBack();
            throw $e;
        }
    }
}

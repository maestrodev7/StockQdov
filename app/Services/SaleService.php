<?php
namespace App\Services;

use App\Interfaces\SaleRepositoryInterface;

class SaleService
{
    protected $saleRepository;

    public function __construct(SaleRepositoryInterface $saleRepository)
    {
        $this->saleRepository = $saleRepository;
    }

    public function createSale(array $data)
    {
        return $this->saleRepository->createSale($data);
    }

    public function getSaleById(int $saleId)
    {
        return $this->saleRepository->getSaleById($saleId);
    }

    public function filterSales(array $filters)
    {
        return $this->saleRepository->filterSales($filters);
    }

    public function updateSale(int $saleId, array $data)
    {
        return $this->saleRepository->updateSale($saleId, $data);
    }

    public function deleteSale(int $saleId)
    {
        return $this->saleRepository->deleteSale($saleId);
    }
}

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
}

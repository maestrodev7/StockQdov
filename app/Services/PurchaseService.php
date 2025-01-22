<?php
namespace App\Services;

use App\Interfaces\PurchaseRepositoryInterface;

class PurchaseService
{
    protected $purchaseRepository;

    public function __construct(PurchaseRepositoryInterface $purchaseRepository)
    {
        $this->purchaseRepository = $purchaseRepository;
    }

    public function createPurchase(array $data)
    {
        return $this->purchaseRepository->createPurchase($data);
    }
}

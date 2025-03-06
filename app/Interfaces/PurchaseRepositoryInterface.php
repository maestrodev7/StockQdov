<?php
namespace App\Interfaces;

interface PurchaseRepositoryInterface
{
    public function createPurchase(array $data);
    public function getAllPurchase();
}

<?php
namespace App\Services;

use App\Interfaces\FournisseurRepositoryInterface;

class FournisseurService
{
    protected $fournisseurRepository;

    public function __construct(FournisseurRepositoryInterface $fournisseurRepository)
    {
        $this->fournisseurRepository = $fournisseurRepository;
    }

    public function getAllFournisseurs($filters = [])
    {
        return $this->fournisseurRepository->getAllFournisseurs($filters);
    }

    public function createFournisseur(array $data)
    {
        return $this->fournisseurRepository->createFournisseur($data);
    }

    public function getFournisseurById($id)
    {
        return $this->fournisseurRepository->getFournisseurById($id);
    }

    public function updateFournisseur($id, array $data)
    {
        return $this->fournisseurRepository->updateFournisseur($id, $data);
    }

    public function deleteFournisseur($id)
    {
        return $this->fournisseurRepository->deleteFournisseur($id);
    }
}

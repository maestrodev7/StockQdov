<?php
namespace App\Services;

use App\Interfaces\BoutiqueRepositoryInterface;

class BoutiqueService
{
    protected $boutiqueRepository;

    public function __construct(BoutiqueRepositoryInterface $boutiqueRepository)
    {
        $this->boutiqueRepository = $boutiqueRepository;
    }

    public function getAllBoutiques()
    {
        return $this->boutiqueRepository->all();
    }

    public function getBoutiqueById(int $id)
    {
        return $this->boutiqueRepository->find($id);
    }

    public function createBoutique(array $data)
    {
        return $this->boutiqueRepository->create($data);
    }

    public function updateBoutique(int $id, array $data)
    {
        return $this->boutiqueRepository->update($id, $data);
    }

    public function deleteBoutique(int $id)
    {
        return $this->boutiqueRepository->delete($id);
    }
}

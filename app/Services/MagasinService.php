<?php
namespace App\Services;

use App\Interfaces\MagasinRepositoryInterface;

class MagasinService
{
    protected $magasinRepository;

    public function __construct(MagasinRepositoryInterface $magasinRepository)
    {
        $this->magasinRepository = $magasinRepository;
    }

    public function getAllMagasins()
    {
        return $this->magasinRepository->all();
    }

    public function getMagasinById(int $id)
    {
        return $this->magasinRepository->find($id);
    }

    public function getMagasinsByEntrepriseId(int $entrepriseId)
    {
        return $this->magasinRepository->getByEntrepriseId($entrepriseId);
    }

    public function createMagasin(array $data)
    {
        return $this->magasinRepository->create($data);
    }

    public function updateMagasin(int $id, array $data)
    {
        return $this->magasinRepository->update($id, $data);
    }

    public function deleteMagasin(int $id)
    {
        return $this->magasinRepository->delete($id);
    }
}

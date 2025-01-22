<?php
namespace App\Services;

use App\Interfaces\EntrepriseRepositoryInterface;

class EntrepriseService
{
    protected $entrepriseRepository;

    public function __construct(EntrepriseRepositoryInterface $entrepriseRepository)
    {
        $this->entrepriseRepository = $entrepriseRepository;
    }

    public function getAllEntreprises()
    {
        return $this->entrepriseRepository->all();
    }

    public function getEntrepriseById(int $id)
    {
        return $this->entrepriseRepository->find($id);
    }

    public function createEntreprise(array $data)
    {
        return $this->entrepriseRepository->create($data);
    }

    public function updateEntreprise(int $id, array $data)
    {
        return $this->entrepriseRepository->update($id, $data);
    }

    public function deleteEntreprise(int $id)
    {
        $this->entrepriseRepository->delete($id);
    }
}

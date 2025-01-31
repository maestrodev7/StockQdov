<?php
namespace App\Services;

use App\Interfaces\CategorieRepositoryInterface;

class CategorieService 
{
    protected $categorieRepository;

    public function __construct(CategorieRepositoryInterface $categorieRepository)
    {
        $this->categorieRepository = $categorieRepository;
    }

    public function getAllCategories()
    {
        return $this->categorieRepository->getAllCategories();
    }

    public function createCategory(array $data)
    {
        return $this->categorieRepository->createCategory($data);
    }
    
    public function deleteCategory($id)
    {
        return $this->categorieRepository->deleteCategory($id);
    }
}

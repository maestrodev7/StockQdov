<?php
namespace App\Repositories;

use App\Models\Categorie;
use App\Interfaces\CategorieRepositoryInterface;

class CategorieRepository implements CategorieRepositoryInterface
{
    public function getAllCategories()
    {
        return Categorie::all();
    }

    public function createCategory(array $data)
    {
        return Categorie::create($data);
    }
}

<?php
namespace App\Interfaces;

interface CategorieRepositoryInterface
{
    public function getAllCategories();
    public function createCategory(array $data);
}

<?php
namespace App\Interfaces;

interface FournisseurRepositoryInterface
{
    public function getAllFournisseurs();
    public function createFournisseur(array $data);
    public function getFournisseurById($id);
    public function updateFournisseur($id, array $data);
    public function deleteFournisseur($id);
}

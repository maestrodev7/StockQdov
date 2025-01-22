<?php
namespace App\Repositories;

use App\Models\Fournisseur;
use App\Interfaces\FournisseurRepositoryInterface;

class FournisseurRepository implements FournisseurRepositoryInterface
{
    public function getAllFournisseurs()
    {
        return Fournisseur::all();
    }

    public function createFournisseur(array $data)
    {
        return Fournisseur::create($data);
    }

    public function getFournisseurById($id)
    {
        return Fournisseur::findOrFail($id);
    }

    public function updateFournisseur($id, array $data)
    {
        $fournisseur = Fournisseur::findOrFail($id);
        $fournisseur->update($data);
        return $fournisseur;
    }

    public function deleteFournisseur($id)
    {
        $fournisseur = Fournisseur::findOrFail($id);
        $fournisseur->delete();
        return true;
    }
}

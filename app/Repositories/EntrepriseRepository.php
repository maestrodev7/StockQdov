<?php
namespace App\Repositories;

use App\Models\Entreprise;
use App\Interfaces\EntrepriseRepositoryInterface;

class EntrepriseRepository implements EntrepriseRepositoryInterface
{
    public function all()
    {
        return Entreprise::all();
    }

    public function create(array $data)
    {
        return Entreprise::create($data);
    }

    public function find(int $id)
    {
        return Entreprise::findOrFail($id);
    }

    public function update(int $id, array $data)
    {
        $entreprise = Entreprise::findOrFail($id);
        $entreprise->update($data);
        return $entreprise;
    }

    public function delete(int $id)
    {
        Entreprise::findOrFail($id)->delete();
    }
}

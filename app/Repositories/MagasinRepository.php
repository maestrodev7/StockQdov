<?php
namespace App\Repositories;

use App\Interfaces\MagasinRepositoryInterface;
use App\Models\Magasin;

class MagasinRepository implements MagasinRepositoryInterface
{
    public function all()
    {
        return Magasin::with('boutiques')->get();
    }

    public function create(array $data)
    {
        return Magasin::create($data);
    }

    public function find(int $id)
    {
        return Magasin::with('boutiques')->findOrFail($id);
    }

    public function getByEntrepriseId(int $entrepriseId)
    {
        return Magasin::where('entreprise_id', $entrepriseId)->get();
    }

    public function update(int $id, array $data)
    {
        $magasin = Magasin::findOrFail($id);
        $magasin->update($data);
        return $magasin;
    }

    public function delete(int $id)
    {
        Magasin::findOrFail($id)->delete();
    }
}

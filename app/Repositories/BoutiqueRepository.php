<?php
namespace App\Repositories;

use App\Interfaces\BoutiqueRepositoryInterface;
use App\Models\Boutique;

class BoutiqueRepository implements BoutiqueRepositoryInterface
{
    public function all()
    {
        return Boutique::with('magasin')->get();
    }

    public function create(array $data)
    {
        return Boutique::create($data);
    }

    public function find(int $id)
    {
        return Boutique::with('magasin')->findOrFail($id);
    }

    public function update(int $id, array $data)
    {
        $boutique = Boutique::findOrFail($id);
        $boutique->update($data);
        return $boutique;
    }

    public function delete(int $id)
    {
        Boutique::findOrFail($id)->delete();
    }
}

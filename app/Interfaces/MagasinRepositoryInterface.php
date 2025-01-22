<?php
namespace App\Interfaces;

interface MagasinRepositoryInterface
{
    public function all();
    public function create(array $data);
    public function find(int $id);
    public function getByEntrepriseId(int $entrepriseId);
    public function update(int $id, array $data);
    public function delete(int $id);
}

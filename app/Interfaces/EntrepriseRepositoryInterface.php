<?php

namespace App\Interfaces;

interface EntrepriseRepositoryInterface
{
    public function all();
    public function create(array $data);
    public function find(int $id);
    public function update(int $id, array $data);
    public function delete(int $id);
}

<?php
namespace App\Interfaces;

interface ClientRepositoryInterface
{
    public function getAllClients();
    public function createClient(array $data);
    public function getClientById($id);
    public function updateClient($id, array $data);
    public function deleteClient($id);
}

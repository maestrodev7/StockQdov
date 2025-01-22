<?php
namespace App\Repositories;

use App\Models\Client;
use App\Interfaces\ClientRepositoryInterface;

class ClientRepository implements ClientRepositoryInterface
{
    public function getAllClients()
    {
        return Client::all();
    }

    public function createClient(array $data)
    {
        return Client::create($data);
    }

    public function getClientById($id)
    {
        return Client::findOrFail($id);
    }

    public function updateClient($id, array $data)
    {
        $client = Client::findOrFail($id);
        $client->update($data);
        return $client;
    }

    public function deleteClient($id)
    {
        $client = Client::findOrFail($id);
        $client->delete();
        return true;
    }
}

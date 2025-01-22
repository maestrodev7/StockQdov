<?php
namespace App\Services;

use App\Interfaces\ClientRepositoryInterface;

class ClientService
{
    protected $clientRepository;

    public function __construct(ClientRepositoryInterface $clientRepository)
    {
        $this->clientRepository = $clientRepository;
    }

    public function getAllClients()
    {
        return $this->clientRepository->getAllClients();
    }

    public function createClient(array $data)
    {
        return $this->clientRepository->createClient($data);
    }

    public function getClientById($id)
    {
        return $this->clientRepository->getClientById($id);
    }

    public function updateClient($id, array $data)
    {
        return $this->clientRepository->updateClient($id, $data);
    }

    public function deleteClient($id)
    {
        return $this->clientRepository->deleteClient($id);
    }
}

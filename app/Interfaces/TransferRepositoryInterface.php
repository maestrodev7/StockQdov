<?php

namespace App\Interfaces;

use Illuminate\Support\Collection;

interface TransferRepositoryInterface
{
    public function create(array $data);
    public function filter(array $filters = []): Collection;
}


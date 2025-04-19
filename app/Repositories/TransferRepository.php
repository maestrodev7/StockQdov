<?php

namespace App\Repositories;

use App\Interfaces\TransferRepositoryInterface;
use App\Models\Transfer;
use Illuminate\Support\Collection;

class TransferRepository implements TransferRepositoryInterface
{

    public function create(array $data): Transfer
    {
        return Transfer::create([
            'produit_id'         => $data['produit_id'],
            'from_location_type' => $data['from_location_type'],
            'from_location_id'   => $data['from_location_id'],
            'to_location_type'   => $data['to_location_type'],
            'to_location_id'     => $data['to_location_id'],
            'quantity'           => $data['quantity'],
            'destination_id'     => $data['destination_id'],
        ]);
    }

    public function filter(array $filters = []): Collection
    {
        $query = Transfer::query();

        if (!empty($filters['start_date'])) {
            $query->whereDate('created_at', '>=', $filters['start_date']);
        }

        if (!empty($filters['end_date'])) {
            $query->whereDate('created_at', '<=', $filters['end_date']);
        }

        if (!empty($filters['from_type']) && !empty($filters['from_id'])) {
            $query->where('from_location_type', $filters['from_type'])
                  ->where('from_location_id', $filters['from_id']);
        }

        if (!empty($filters['to_type']) && !empty($filters['to_id'])) {
            $query->where('to_location_type', $filters['to_type'])
                  ->where('to_location_id', $filters['to_id']);
        }

        return $query->get();
    }
}

<?php

namespace App\Services;

use App\Interfaces\ProduitRepositoryInterface;
use App\Interfaces\MagasinRepositoryInterface;
use App\Interfaces\BoutiqueRepositoryInterface;
use App\Interfaces\TransferRepositoryInterface;
use App\Http\Requests\TransferRequest;
use Illuminate\Support\Facades\DB;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\HttpException;
use Illuminate\Support\Collection;

class TransferService
{
    protected ProduitRepositoryInterface $produitRepo;
    protected MagasinRepositoryInterface $magasinRepo;
    protected BoutiqueRepositoryInterface $boutiqueRepo;
    protected TransferRepositoryInterface $transferRepo;

    public function __construct(
        ProduitRepositoryInterface $produitRepo,
        MagasinRepositoryInterface $magasinRepo,
        BoutiqueRepositoryInterface $boutiqueRepo,
        TransferRepositoryInterface $transferRepo
    ) {
        $this->produitRepo  = $produitRepo;
        $this->magasinRepo  = $magasinRepo;
        $this->boutiqueRepo = $boutiqueRepo;
        $this->transferRepo = $transferRepo;
    }

    /**
     * Transfer a product between two locations.
     *
     * @throws HttpException if validation or stock checks fail.
     */
    public function transfer(
        string $fromType,
        int    $fromId,
        string $toType,
        int    $toId,
        int    $productId,
        int    $quantity
    ) {
        // Validate types
        if (!in_array($fromType, [TransferRequest::TYPE_STORE, TransferRequest::TYPE_SHOP], true)
            || !in_array($toType, [TransferRequest::TYPE_STORE, TransferRequest::TYPE_SHOP], true)
        ) {
            throw new HttpException(
                Response::HTTP_BAD_REQUEST,
                'Invalid location type.'
            );
        }

        return DB::transaction(function () use (
            $fromType, $fromId,
            $toType,   $toId,
            $productId, $quantity
        ) {
            // Ensure origin exists
            if ($fromType === TransferRequest::TYPE_STORE) {
                $this->magasinRepo->find($fromId);
            } else {
                $this->boutiqueRepo->find($fromId);
            }
            // Ensure destination exists
            if ($toType === TransferRequest::TYPE_STORE) {
                $this->magasinRepo->find($toId);
            } else {
                $this->boutiqueRepo->find($toId);
            }

            // Fetch and validate product in origin
            $product = $this->produitRepo->getProduitById($productId);

            if ($fromType === TransferRequest::TYPE_STORE
                && $product->magasin_id !== $fromId
            ) {
                throw new HttpException(
                    Response::HTTP_UNPROCESSABLE_ENTITY,
                    'Product not found in the specified store.'
                );
            }

            if ($fromType === TransferRequest::TYPE_SHOP
                && $product->boutique_id !== $fromId
            ) {
                throw new HttpException(
                    Response::HTTP_UNPROCESSABLE_ENTITY,
                    'Product not found in the specified shop.'
                );
            }

            if ($product->quantite < $quantity) {
                throw new HttpException(
                    Response::HTTP_UNPROCESSABLE_ENTITY,
                    'Insufficient stock in origin location.'
                );
            }

            // Decrement stock at origin
            $this->produitRepo->decrementStock($productId, $quantity);

            // Handle destination stock (find existing or create)
            if ($toType === TransferRequest::TYPE_STORE) {
                $list = $this->produitRepo->getByMagasin($toId);
            } else {
                $list = $this->produitRepo->getByBoutique($toId);
            }

            $destProduct = collect($list)
                ->first(fn($p) => $p->nom === $product->nom
                                 && $p->categorie_id === $product->categorie_id
                );

            if ($destProduct) {
                $this->produitRepo->incrementStock($destProduct->id, $quantity);
                $destId = $destProduct->id;
            } else {
                $data = [
                    'nom'           => $product->nom,
                    'description'   => $product->description,
                    'prix_achat'    => $product->prix_achat,
                    'prix_vente'    => $product->prix_vente,
                    'categorie_id'  => $product->categorie_id,
                    'date_peremption'=> $product->date_peremption,
                    'type'          => $product->type,
                    'quantite'      => $quantity,
                    'magasin_id'    => $toType === TransferRequest::TYPE_STORE ? $toId : null,
                    'boutique_id'   => $toType === TransferRequest::TYPE_SHOP  ? $toId : null,
                ];
                $new = $this->produitRepo->create($data);
                $destId = $new->id;
            }

            // Persist the transfer record
            return $this->transferRepo->create([
                'produit_id'         => $productId,
                'from_location_type' => $fromType,
                'from_location_id'   => $fromId,
                'to_location_type'   => $toType,
                'to_location_id'     => $toId,
                'quantity'           => $quantity,
                'destination_id'     => $destId,
            ]);
        });
    }

    public function filter(array $filters = []): Collection
    {
        return $this->transferRepo->filter($filters);
    }
}

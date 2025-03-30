<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\PurchaseRequest;
use App\Http\Requests\UpdatePurchaseRequest;
use App\Services\PurchaseService;
use App\Traits\ApiResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;
use Illuminate\Database\QueryException;
use Symfony\Component\HttpFoundation\Response;
use Exception;

class PurchaseController extends Controller
{
    use ApiResponse;

    protected $purchaseService;

    public function __construct(PurchaseService $purchaseService)
    {
        $this->purchaseService = $purchaseService;
    }


    public function store(PurchaseRequest $request)
    {
        try {
            $purchase = $this->purchaseService->createPurchase($request->validated());

            return $this->success($purchase, 'Achat enregistré avec succès.');
        } catch (ValidationException $e) {
            return $this->error(
                'Erreur de validation : ' . implode(', ', $e->errors()),
                Response::HTTP_UNPROCESSABLE_ENTITY
            );
        } catch (QueryException $e) {
            return $this->error(
                'Erreur de base de données : ' . $e->getMessage(),
                Response::HTTP_INTERNAL_SERVER_ERROR
            );
        } catch (Exception $e) {
            return $this->error(
                'Erreur inattendue : ' . $e->getMessage(),
                Response::HTTP_INTERNAL_SERVER_ERROR
            );
        }
    }

    public function show(int $id)
    {
        try {
            $purchase = $this->purchaseService->getPurchaseById($id);

            return $this->success($purchase, 'Détails de l\'achat récupérés avec succès.');
        } catch (QueryException $e) {
            return $this->error('Erreur de base de données : ' . $e->getMessage(), Response::HTTP_INTERNAL_SERVER_ERROR);
        } catch (Exception $e) {
            return $this->error('Erreur : ' . $e->getMessage(), Response::HTTP_NOT_FOUND);
        }
    }

    public function update(UpdatePurchaseRequest $request, int $id)
    {
        try {
            $purchase = $this->purchaseService->updatePurchase($id, $request->validated());

            return $this->success($purchase, 'Achat mis à jour avec succès.');
        } catch (ValidationException $e) {
            return $this->error('Erreur de validation : ' . implode(', ', $e->errors()), Response::HTTP_UNPROCESSABLE_ENTITY);
        } catch (QueryException $e) {
            return $this->error('Erreur SQL : ' . $e->getMessage(), Response::HTTP_INTERNAL_SERVER_ERROR);
        } catch (Exception $e) {
            return $this->error('Erreur inattendue : ' . $e->getMessage(), Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    public function destroy(int $id)
    {
        try {
            $this->purchaseService->deletePurchase($id);

            return $this->success(null, 'Achat supprimé avec succès.');
        } catch (QueryException $e) {
            return $this->error('Erreur de base de données : ' . $e->getMessage(), Response::HTTP_INTERNAL_SERVER_ERROR);
        } catch (Exception $e) {
            return $this->error('Erreur : ' . $e->getMessage(), Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    public function filter(Request $request)
    {
        try {
            $purchases = $this->purchaseService->filterPurchases($request->all());

            return $this->success($purchases, 'Achats filtrés avec succès.');
        } catch (QueryException $e) {
            return $this->error('Erreur SQL : ' . $e->getMessage(), Response::HTTP_INTERNAL_SERVER_ERROR);
        } catch (Exception $e) {
            return $this->error('Erreur inattendue : ' . $e->getMessage(), Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }
}

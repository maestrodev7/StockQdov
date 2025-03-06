<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\PurchaseRequest;
use App\Services\PurchaseService;
use App\Traits\ApiResponse;
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

            return $this->success($purchase, 'Purchase created successfully.');
        } catch (ValidationException $e) {
            return $this->error(
                'Validation error: ' . implode(', ', $e->errors()),
                Response::HTTP_UNPROCESSABLE_ENTITY
            );
        } catch (QueryException $e) {
            return $this->error(
                'Database error: ' . $e->getMessage(),
                Response::HTTP_INTERNAL_SERVER_ERROR
            );
        } catch (Exception $e) {
            return $this->error(
                'An unexpected error occurred: ' . $e->getMessage(),
                Response::HTTP_INTERNAL_SERVER_ERROR
            );
        }
    }

    public function index()
    {
        try {
            $purchase = $this->purchaseService->getAllPurchase();

            return $this->success($purchase, 'Liste des achats récupérée avec succès.');
        } catch (QueryException $e) {
            return $this->error('Erreur de base de données : ' . $e->getMessage(), Response::HTTP_INTERNAL_SERVER_ERROR);
        } catch (Exception $e) {
            return $this->error('Une erreur inattendue est survenue : ' . $e->getMessage(), Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }
}

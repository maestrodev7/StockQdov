<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\BoutiqueRequest;
use App\Services\BoutiqueService;
use App\Traits\ApiResponse;
use Illuminate\Validation\ValidationException;
use Illuminate\Database\QueryException;
use Symfony\Component\HttpFoundation\Response;
use Exception;

class BoutiqueController extends Controller
{
    use ApiResponse;

    protected $boutiqueService;

    public function __construct(BoutiqueService $boutiqueService)
    {
        $this->boutiqueService = $boutiqueService;
    }

    public function index()
    {
        try {
            $boutiques = $this->boutiqueService->getAllBoutiques();
            return $this->success($boutiques, 'Liste des boutiques récupérée avec succès.');
        } catch (QueryException $e) {
            return $this->error('Erreur de base de données : ' . $e->getMessage(), Response::HTTP_INTERNAL_SERVER_ERROR);
        } catch (Exception $e) {
            return $this->error('Une erreur inattendue est survenue : ' . $e->getMessage(), Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    public function store(BoutiqueRequest $request)
    {
        try {
            $boutique = $this->boutiqueService->createBoutique($request->validated());
            return $this->success($boutique, 'Boutique créée avec succès.', Response::HTTP_CREATED);
        } catch (ValidationException $e) {
            return $this->error('Erreur de validation : ' . implode(', ', $e->errors()), Response::HTTP_UNPROCESSABLE_ENTITY);
        } catch (QueryException $e) {
            return $this->error('Erreur de base de données : ' . $e->getMessage(), Response::HTTP_INTERNAL_SERVER_ERROR);
        } catch (Exception $e) {
            return $this->error('Une erreur inattendue est survenue : ' . $e->getMessage(), Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    public function show($id)
    {
        try {
            $boutique = $this->boutiqueService->getBoutiqueById($id);
            return $this->success($boutique, 'Détails de la boutique récupérés avec succès.');
        } catch (QueryException $e) {
            return $this->error('Erreur de base de données : ' . $e->getMessage(), Response::HTTP_INTERNAL_SERVER_ERROR);
        } catch (Exception $e) {
            return $this->error('Une erreur inattendue est survenue : ' . $e->getMessage(), Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    public function update(BoutiqueRequest $request, $id)
    {
        try {
            $boutique = $this->boutiqueService->updateBoutique($id, $request->validated());
            return $this->success($boutique, 'Boutique mise à jour avec succès.');
        } catch (ValidationException $e) {
            return $this->error('Erreur de validation : ' . implode(', ', $e->errors()), Response::HTTP_UNPROCESSABLE_ENTITY);
        } catch (QueryException $e) {
            return $this->error('Erreur de base de données : ' . $e->getMessage(), Response::HTTP_INTERNAL_SERVER_ERROR);
        } catch (Exception $e) {
            return $this->error('Une erreur inattendue est survenue : ' . $e->getMessage(), Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    public function destroy($id)
    {
        try {
            $this->boutiqueService->deleteBoutique($id);
            return $this->success(null, 'Boutique supprimée avec succès.');
        } catch (QueryException $e) {
            return $this->error('Erreur de base de données : ' . $e->getMessage(), Response::HTTP_INTERNAL_SERVER_ERROR);
        } catch (Exception $e) {
            return $this->error('Une erreur inattendue est survenue : ' . $e->getMessage(), Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }
}

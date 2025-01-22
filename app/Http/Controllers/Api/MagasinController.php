<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\MagasinRequest;
use App\Services\MagasinService;
use App\Traits\ApiResponse;
use Illuminate\Validation\ValidationException;
use Illuminate\Database\QueryException;
use Symfony\Component\HttpFoundation\Response;
use Exception;

class MagasinController extends Controller
{
    use ApiResponse;

    protected $magasinService;

    public function __construct(MagasinService $magasinService)
    {
        $this->magasinService = $magasinService;
    }

    public function index()
    {
        try {
            return $this->success($this->magasinService->getAllMagasins());
        } catch (QueryException $e) {
            return $this->error('Erreur de base de données : ' . $e->getMessage(), Response::HTTP_INTERNAL_SERVER_ERROR);
        } catch (Exception $e) {
            return $this->error('Une erreur inattendue est survenue : ' . $e->getMessage(), Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    public function show($id)
    {
        try {
            $magasin = $this->magasinService->getMagasinById($id);
            return $this->success($magasin, 'Magasin récupéré avec succès.');
        } catch (QueryException $e) {
            return $this->error('Erreur de base de données : ' . $e->getMessage(), Response::HTTP_INTERNAL_SERVER_ERROR);
        } catch (Exception $e) {
            return $this->error('Une erreur inattendue est survenue : ' . $e->getMessage(), Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    public function getByEntreprise($entrepriseId)
    {
        try {
            $magasins = $this->magasinService->getMagasinsByEntrepriseId($entrepriseId);
            return $this->success($magasins, 'Magasins de l\'entreprise récupérés avec succès.');
        } catch (QueryException $e) {
            return $this->error('Erreur de base de données : ' . $e->getMessage(), Response::HTTP_INTERNAL_SERVER_ERROR);
        } catch (Exception $e) {
            return $this->error('Une erreur inattendue est survenue : ' . $e->getMessage(), Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    public function store(MagasinRequest $request)
    {
        try {
            return $this->success(
                $this->magasinService->createMagasin($request->validated()),
                'Magasin créé avec succès.',
                Response::HTTP_CREATED
            );
        } catch (ValidationException $e) {
            return $this->error('Erreur de validation : ' . implode(', ', $e->errors()), Response::HTTP_UNPROCESSABLE_ENTITY);
        } catch (QueryException $e) {
            return $this->error('Erreur de base de données : ' . $e->getMessage(), Response::HTTP_INTERNAL_SERVER_ERROR);
        } catch (Exception $e) {
            return $this->error('Une erreur inattendue est survenue : ' . $e->getMessage(), Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    public function update(MagasinRequest $request, $id)
    {
        try {
            return $this->success(
                $this->magasinService->updateMagasin($id, $request->validated()),
                'Magasin mis à jour avec succès.'
            );
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
            $this->magasinService->deleteMagasin($id);
            return $this->success(null, 'Magasin supprimé avec succès.');
        } catch (QueryException $e) {
            return $this->error('Erreur de base de données : ' . $e->getMessage(), Response::HTTP_INTERNAL_SERVER_ERROR);
        } catch (Exception $e) {
            return $this->error('Une erreur inattendue est survenue : ' . $e->getMessage(), Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }
}

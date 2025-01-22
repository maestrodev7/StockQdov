<?php
namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\EntrepriseRequest;
use App\Services\EntrepriseService;
use App\Traits\ApiResponse;
use Illuminate\Validation\ValidationException;
use Illuminate\Database\QueryException;
use Symfony\Component\HttpFoundation\Response;
use Exception;

class EntrepriseController extends Controller
{
    use ApiResponse;

    protected $entrepriseService;

    public function __construct(EntrepriseService $entrepriseService)
    {
        $this->entrepriseService = $entrepriseService;
    }

    public function index()
    {
        try {
            return $this->success($this->entrepriseService->getAllEntreprises());
        } catch (QueryException $e) {
            return $this->error('Erreur de base de données : ' . $e->getMessage(), Response::HTTP_INTERNAL_SERVER_ERROR);
        } catch (Exception $e) {
            return $this->error('Une erreur inattendue est survenue : ' . $e->getMessage(), Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    public function show($id)
    {
        try {
            $entreprise = $this->entrepriseService->getEntrepriseById($id);
            return $this->success($entreprise, 'Entreprise récupérée avec succès.');
        } catch (QueryException $e) {
            return $this->error('Erreur de base de données : ' . $e->getMessage(), Response::HTTP_INTERNAL_SERVER_ERROR);
        } catch (Exception $e) {
            return $this->error('Une erreur inattendue est survenue : ' . $e->getMessage(), Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    public function store(EntrepriseRequest $request)
    {
        try {
            $entreprise = $this->entrepriseService->createEntreprise($request->validated());
            return $this->success($entreprise, 'Entreprise créée avec succès', Response::HTTP_CREATED);
        } catch (ValidationException $e) {
            return $this->error('Erreur de validation : ' . implode(', ', $e->errors()), Response::HTTP_UNPROCESSABLE_ENTITY);
        } catch (QueryException $e) {
            return $this->error('Erreur de base de données : ' . $e->getMessage(), Response::HTTP_INTERNAL_SERVER_ERROR);
        } catch (Exception $e) {
            return $this->error('Une erreur inattendue est survenue : ' . $e->getMessage(), Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    public function update(EntrepriseRequest $request, $id)
    {
        try {
            $entreprise = $this->entrepriseService->updateEntreprise($id, $request->validated());
            return $this->success($entreprise, 'Entreprise mise à jour avec succès');
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
            $this->entrepriseService->deleteEntreprise($id);
            return $this->success(null, 'Entreprise supprimée avec succès');
        } catch (QueryException $e) {
            return $this->error('Erreur de base de données : ' . $e->getMessage(), Response::HTTP_INTERNAL_SERVER_ERROR);
        } catch (Exception $e) {
            return $this->error('Une erreur inattendue est survenue : ' . $e->getMessage(), Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }
}

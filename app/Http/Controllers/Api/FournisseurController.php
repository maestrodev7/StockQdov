<?php
namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\FournisseurRequest;
use App\Services\FournisseurService;
use App\Traits\ApiResponse;
use Illuminate\Database\QueryException;
use Symfony\Component\HttpFoundation\Response;
use Exception;

class FournisseurController extends Controller
{
    use ApiResponse;

    protected $fournisseurService;

    public function __construct(FournisseurService $fournisseurService)
    {
        $this->fournisseurService = $fournisseurService;
    }

    public function index()
    {
        try {
            $fournisseurs = $this->fournisseurService->getAllFournisseurs();
            return $this->success($fournisseurs, 'Liste des fournisseurs récupérée avec succès.');
        } catch (QueryException $e) {
            return $this->error('Erreur de base de données : ' . $e->getMessage(), Response::HTTP_INTERNAL_SERVER_ERROR);
        } catch (Exception $e) {
            return $this->error('Une erreur inattendue est survenue : ' . $e->getMessage(), Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    public function store(FournisseurRequest $request)
    {
        try {
            $fournisseur = $this->fournisseurService->createFournisseur($request->validated());
            return $this->success($fournisseur, 'Fournisseur créé avec succès.', Response::HTTP_CREATED);
        } catch (QueryException $e) {
            return $this->error('Erreur de base de données : ' . $e->getMessage(), Response::HTTP_INTERNAL_SERVER_ERROR);
        } catch (Exception $e) {
            return $this->error('Une erreur inattendue est survenue : ' . $e->getMessage(), Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    public function show($id)
    {
        try {
            $fournisseur = $this->fournisseurService->getFournisseurById($id);
            return $this->success($fournisseur, 'Fournisseur récupéré avec succès.');
        } catch (QueryException $e) {
            return $this->error('Erreur de base de données : ' . $e->getMessage(), Response::HTTP_INTERNAL_SERVER_ERROR);
        } catch (Exception $e) {
            return $this->error('Une erreur inattendue est survenue : ' . $e->getMessage(), Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    public function update(FournisseurRequest $request, $id)
    {
        try {
            $fournisseur = $this->fournisseurService->updateFournisseur($id, $request->validated());
            return $this->success($fournisseur, 'Fournisseur mis à jour avec succès.');
        } catch (QueryException $e) {
            return $this->error('Erreur de base de données : ' . $e->getMessage(), Response::HTTP_INTERNAL_SERVER_ERROR);
        } catch (Exception $e) {
            return $this->error('Une erreur inattendue est survenue : ' . $e->getMessage(), Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    public function destroy($id)
    {
        try {
            $this->fournisseurService->deleteFournisseur($id);
            return $this->success(null, 'Fournisseur supprimé avec succès.');
        } catch (QueryException $e) {
            return $this->error('Erreur de base de données : ' . $e->getMessage(), Response::HTTP_INTERNAL_SERVER_ERROR);
        } catch (Exception $e) {
            return $this->error('Une erreur inattendue est survenue : ' . $e->getMessage(), Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }
}

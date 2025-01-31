<?php
namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\CategorieRequest;
use App\Services\CategorieService;
use App\Traits\ApiResponse;
use Illuminate\Database\QueryException;
use Symfony\Component\HttpFoundation\Response;
use Exception;

class CategorieController extends Controller
{
    use ApiResponse;

    protected $categorieService;

    public function __construct(CategorieService $categorieService)
    {
        $this->categorieService = $categorieService;
    }

    public function index()
    {
        try {
            $categories = $this->categorieService->getAllCategories();
            return $this->success($categories, 'Liste des catégories récupérée avec succès.');
        } catch (QueryException $e) {
            return $this->error('Erreur de base de données : ' . $e->getMessage(), Response::HTTP_INTERNAL_SERVER_ERROR);
        } catch (Exception $e) {
            return $this->error('Une erreur inattendue est survenue : ' . $e->getMessage(), Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    public function store(CategorieRequest $request)
    {
        try {
            $categorie = $this->categorieService->createCategory($request->validated());
            return $this->success($categorie, 'Catégorie créée avec succès.', Response::HTTP_CREATED);
        } catch (QueryException $e) {
            return $this->error('Erreur de base de données : ' . $e->getMessage(), Response::HTTP_INTERNAL_SERVER_ERROR);
        } catch (Exception $e) {
            return $this->error('Une erreur inattendue est survenue : ' . $e->getMessage(), Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }
    
    public function destroy($id)
    {
        try {
            $this->categorieService->deleteCategory($id);
            return $this->success(null, 'categorie supprimée avec succès.');
        } catch (QueryException $e) {
            return $this->error('Erreur de base de données : ' . $e->getMessage(), Response::HTTP_INTERNAL_SERVER_ERROR);
        } catch (Exception $e) {
            return $this->error('Une erreur inattendue est survenue : ' . $e->getMessage(), Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }
}

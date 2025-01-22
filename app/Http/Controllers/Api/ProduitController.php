<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\ProduitRequest;
use App\Services\ProduitService;
use App\Traits\ApiResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;
use Illuminate\Database\QueryException;
use Symfony\Component\HttpFoundation\Response;
use Exception;

class ProduitController extends Controller
{
    use ApiResponse;

    protected $produitService;

    public function __construct(ProduitService $produitService)
    {
        $this->produitService = $produitService;
    }

    public function ajouterAuMagasin(ProduitRequest $request)
    {
        try {
            $produit = $this->produitService->ajouterAuMagasin($request->validated());

            return $this->success($produit, 'Produit ajouté au magasin avec succès.');
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
                'Une erreur inattendue est survenue : ' . $e->getMessage(),
                Response::HTTP_INTERNAL_SERVER_ERROR 
            );
        }
    }

    public function ajouterALaBoutique(ProduitRequest $request)
    {
        try {
            $produit = $this->produitService->ajouterALaBoutique($request->validated());

            return $this->success($produit, 'Produit ajouté à la boutique avec succès.');
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
                'Une erreur inattendue est survenue : ' . $e->getMessage(),
                Response::HTTP_INTERNAL_SERVER_ERROR 
            );
        }
    }

    public function getByBoutique(Request $request, $boutiqueId)
    {
        try {
            $produits = $this->produitService->getByBoutique($boutiqueId, $request->all());
            return $this->success($produits, 'Produits de la boutique récupérés avec succès.');
        } catch (QueryException $e) {
            return $this->error('Erreur de base de données : ' . $e->getMessage(), Response::HTTP_INTERNAL_SERVER_ERROR);
        } catch (Exception $e) {
            return $this->error('Une erreur inattendue est survenue : ' . $e->getMessage(), Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    public function getByMagasin(Request $request, $magasinId)
    {
        try {
            $produits = $this->produitService->getByMagasin($magasinId, $request->all());
            return $this->success($produits, 'Produits du magasin récupérés avec succès.');
        } catch (QueryException $e) {
            return $this->error('Erreur de base de données : ' . $e->getMessage(), Response::HTTP_INTERNAL_SERVER_ERROR);
        } catch (Exception $e) {
            return $this->error('Une erreur inattendue est survenue : ' . $e->getMessage(), Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    public function getProduitByBoutique($boutiqueId, $id)
    {
        try {
            $produit = $this->produitService->getProduitByBoutique($boutiqueId, $id);
            return $this->success($produit, 'Produit de la boutique récupéré avec succès.');
        } catch (QueryException $e) {
            return $this->error('Erreur de base de données : ' . $e->getMessage(), Response::HTTP_INTERNAL_SERVER_ERROR);
        } catch (Exception $e) {
            return $this->error('Une erreur inattendue est survenue : ' . $e->getMessage(), Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    public function getProduitByMagasin($magasinId, $id)
    {
        try {
            $produit = $this->produitService->getProduitByMagasin($magasinId, $id);
            return $this->success($produit, 'Produit du magasin récupéré avec succès.');
        } catch (QueryException $e) {
            return $this->error('Erreur de base de données : ' . $e->getMessage(), Response::HTTP_INTERNAL_SERVER_ERROR);
        } catch (Exception $e) {
            return $this->error('Une erreur inattendue est survenue : ' . $e->getMessage(), Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    public function update(ProduitRequest $request, $id)
    {
        try {
            $produit = $this->produitService->update($id, $request->validated());
            return $this->success($produit, 'Produit mis à jour avec succès.');
        } catch (QueryException $e) {
            return $this->error('Erreur de base de données : ' . $e->getMessage(), Response::HTTP_INTERNAL_SERVER_ERROR);
        } catch (Exception $e) {
            return $this->error('Une erreur inattendue est survenue : ' . $e->getMessage(), Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    public function destroy($id)
    {
        try {
            $this->produitService->delete($id);
            return $this->success(null, 'Produit supprimé avec succès.');
        } catch (QueryException $e) {
            return $this->error('Erreur de base de données : ' . $e->getMessage(), Response::HTTP_INTERNAL_SERVER_ERROR);
        } catch (Exception $e) {
            return $this->error('Une erreur inattendue est survenue : ' . $e->getMessage(), Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }
}

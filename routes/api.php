<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\EntrepriseController;
use App\Http\Controllers\Api\MagasinController;
use App\Http\Controllers\Api\BoutiqueController;
use App\Http\Controllers\Api\CategorieController;
use App\Http\Controllers\Api\ProduitController;
use App\Http\Controllers\Api\ClientController;
use App\Http\Controllers\Api\FournisseurController;
use App\Http\Controllers\Api\PurchaseController;
use App\Http\Controllers\Api\SaleController;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');


Route::apiResource('clients', ClientController::class);
Route::apiResource('fournisseurs', FournisseurController::class);

Route::apiResource('/purchases', PurchaseController::class);
Route::post('/sales', [SaleController::class, 'store']);


Route::apiResource('categories', CategorieController::class);
Route::post('produits/magasin', [ProduitController::class, 'ajouterAuMagasin']);
Route::post('produits/boutique', [ProduitController::class, 'ajouterALaBoutique']);
Route::get('produits/boutique/{boutiqueId}', [ProduitController::class, 'getByBoutique']);
Route::get('produits/magasin/{magasinId}', [ProduitController::class, 'getByMagasin']);
Route::get('produits/{id}', [ProduitController::class, 'getProduitById']);
Route::put('produits/{id}', [ProduitController::class, 'update']);
Route::delete('produits/{id}', [ProduitController::class, 'destroy']);

Route::apiResource('entreprises', EntrepriseController::class);
Route::apiResource('magasins', MagasinController::class);
Route::apiResource('boutiques', BoutiqueController::class);
Route::get('entreprises/{id}/magasins', [MagasinController::class, 'getByEntreprise']);
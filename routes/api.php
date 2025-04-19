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
use App\Http\Controllers\Api\TransferController;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');


Route::apiResource('transfer', TransferController::class);

Route::apiResource('clients', ClientController::class);
Route::apiResource('fournisseurs', FournisseurController::class);

Route::get('/purchases', [PurchaseController::class, 'filter']);
Route::post('/purchases', [PurchaseController::class, 'store']);
Route::get('/purchases/{id}', [PurchaseController::class, 'show']);
Route::put('/purchases/{id}', [PurchaseController::class, 'update']);
Route::delete('/purchases/{id}', [PurchaseController::class, 'destroy']);


Route::post('/sales', [SaleController::class, 'store']);
Route::get('/sales', [SaleController::class, 'index']);
Route::get('/sales/{id}', [SaleController::class, 'show']);
Route::put('/sales/{id}', [SaleController::class, 'update']);
Route::delete('/sales/{id}', [SaleController::class, 'destroy']);

Route::apiResource('categories', CategorieController::class);
Route::get('produits', [ProduitController::class, 'getProduitsByFilter']);
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

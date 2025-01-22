<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Interfaces\EntrepriseRepositoryInterface;
use App\Repositories\EntrepriseRepository;
use App\Interfaces\MagasinRepositoryInterface;
use App\Repositories\MagasinRepository;
use App\Interfaces\BoutiqueRepositoryInterface;
use App\Repositories\BoutiqueRepository;
use App\Interfaces\ProduitRepositoryInterface;
use App\Repositories\ProduitRepository;
use App\Interfaces\CategorieRepositoryInterface;
use App\Repositories\CategorieRepository;
use App\Interfaces\ClientRepositoryInterface;
use App\Repositories\ClientRepository;
use App\Interfaces\FournisseurRepositoryInterface;
use App\Repositories\FournisseurRepository;
use App\Interfaces\PurchaseRepositoryInterface;
use App\Repositories\PurchaseRepository;
use App\Interfaces\SaleRepositoryInterface;
use App\Repositories\SaleRepository;



class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->bind(EntrepriseRepositoryInterface::class, EntrepriseRepository::class);
        $this->app->bind(MagasinRepositoryInterface::class, MagasinRepository::class);
        $this->app->bind(BoutiqueRepositoryInterface::class, BoutiqueRepository::class);
        $this->app->bind(ProduitRepositoryInterface::class, ProduitRepository::class);
        $this->app->bind(CategorieRepositoryInterface::class, CategorieRepository::class);
        $this->app->bind(ClientRepositoryInterface::class, ClientRepository::class);
        $this->app->bind(FournisseurRepositoryInterface::class, FournisseurRepository::class);
        $this->app->bind(PurchaseRepositoryInterface::class, PurchaseRepository::class);
        $this->app->bind(SaleRepositoryInterface::class, SaleRepository::class);
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
    }
}

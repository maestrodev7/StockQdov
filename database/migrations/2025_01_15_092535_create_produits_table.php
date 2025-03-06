<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('produits', function (Blueprint $table) {
            $table->id();
            $table->string('nom');
            $table->text('description')->nullable();
            $table->decimal('prix_achat', 10, 2);
            $table->decimal('prix_vente', 10, 2);
            $table->unsignedBigInteger('categorie_id');
            $table->date('date_peremption')->nullable();
            $table->string('type')->nullable();
            $table->integer('quantite');
            $table->unsignedBigInteger('magasin_id')->nullable();
            $table->unsignedBigInteger('boutique_id')->nullable();
            $table->timestamps();
        
            $table->foreign('categorie_id')->references('id')->on('categories')->onDelete('cascade');
            $table->foreign('magasin_id')->references('id')->on('magasins')->onDelete('cascade');
            $table->foreign('boutique_id')->references('id')->on('boutiques')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('produits');
    }
};

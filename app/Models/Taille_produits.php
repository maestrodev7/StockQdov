<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Taille_produits extends Model
{
    protected $table = 'taille_produits';

    protected $fillable = [
        'produit_id',
        'taille',
        'prix_achat',
        'prix_vente',
        'quantite',
    ];

    public function produit(): BelongsTo
    {
        return $this->belongsTo(Produit::class);
    }
}

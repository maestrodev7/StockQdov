<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Magasin extends Model
{
    protected $fillable = ['nom', 'adresse', 'telephone', 'entreprise_id'];

    public function entreprise()
    {
        return $this->belongsTo(Entreprise::class);
    }

    public function boutiques()
    {
        return $this->hasMany(Boutique::class);
    }
}

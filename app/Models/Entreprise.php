<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Entreprise extends Model
{
    protected $fillable = [
        'nom', 'logo', 'adresse', 'telephone', 'email', 'site_web'
    ];

    public function magasins()
    {
        return $this->hasMany(Magasin::class);
    }

}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Boutique extends Model
{
    protected $fillable = ['nom', 'adresse', 'telephone', 'magasin_id'];

    public function magasin()
    {
        return $this->belongsTo(Magasin::class);
    }
}


<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Fournisseur extends Model
{
    use HasFactory;

    protected $fillable = ['nom', 'telephone', 'adresse'];

    public function purchases()
    {
        return $this->hasMany(Purchase::class);
    }

}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Transfer extends Model
{
    protected $fillable = ['produit_id','from_location_type','from_location_id',
                          'to_location_type','to_location_id','quantity'];

    public function produit()
    {
        return $this->belongsTo(Produit::class);
    }

    public function fromLocation()
    {
        return $this->morphTo();
    }

    public function toLocation()
    {
        return $this->morphTo();
    }
}

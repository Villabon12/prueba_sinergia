<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    protected $table = 'productos';

    protected $fillable = ['name', 'description', 'product_type_id'];

    public function productType()
    {
        return $this->belongsTo(ProductType::class);
    }

    public function terrestrialShipments()
    {
        return $this->hasMany(TerrestrialShipment::class);
    }

    public function maritimeShipments()
    {
        return $this->hasMany(MaritimeShipment::class);
    }
}
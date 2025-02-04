<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ShipmentDetail extends Model
{
    use HasFactory;

    protected $table = 'detalles_envios';

    protected $fillable = ['quantity', 'product_id', 'shipment_id', 'shipment_maritimo_id'];

    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    public function terrestrialShipment()
    {
        return $this->belongsTo(TerrestrialShipment::class, 'shipment_id');
    }

    public function maritimeShipment()
    {
        return $this->belongsTo(MaritimeShipment::class, 'shipment_maritimo_id');
    }
}
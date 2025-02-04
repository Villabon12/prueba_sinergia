<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TerrestrialShipment extends Model
{
    use HasFactory;

    protected $table = 'logistica_terrestre';

    protected $fillable = [
        'product_id', 'customer_id', 'warehouse_id', 'quantity', 
        'registered_at', 'delivered_at', 'shipping_price', 
        'fleet_plate', 'tracking_number', 'discount_applied'
    ];

    public function calculateDiscount()
    {
        // Si la cantidad de productos es mayor a 10, aplicamos un descuento
        if ($this->quantity > 10) {
            $this->discount_applied = $this->shipping_price * 0.1; // 10% de descuento
            $this->save(); // Guarda el descuento aplicado
        }
    }

    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    public function customer()
    {
        return $this->belongsTo(Customer::class);
    }

    public function warehouse()
    {
        return $this->belongsTo(Warehouse::class);
    }

    public function shipmentDetails()
    {
        return $this->hasMany(ShipmentDetail::class);
    }
}

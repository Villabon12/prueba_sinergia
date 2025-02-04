<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Warehouse extends Model
{
    use HasFactory;

    protected $table = 'bodegas';

    protected $fillable = ['name', 'location', 'storage_capacity', 'warehouse_type_id'];

    public function warehouseType()
    {
        return $this->belongsTo(WarehouseType::class);
    }

    public function terrestrialShipments()
    {
        return $this->hasMany(TerrestrialShipment::class);
    }
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class WarehouseType extends Model
{
    use HasFactory;

    protected $table = 'tipos_bodegas';

    protected $fillable = ['type'];

    public function warehouses()
    {
        return $this->hasMany(Warehouse::class);
    }
}
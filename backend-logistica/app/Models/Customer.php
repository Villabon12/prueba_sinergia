<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Customer extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'clientes';

    protected $fillable = [
        'full_name', 'phone', 'address', 'email', 'customer_type_id'
    ];

    public function customerType()
    {
        return $this->belongsTo(CustomerType::class);
    }

    public function terrestrialShipment()
    {
        return $this->hasMany(TerrestrialShipment::class);
    }

    public function maritimeShipments()
    {
        return $this->hasMany(MaritimeShipment::class);
    }
}
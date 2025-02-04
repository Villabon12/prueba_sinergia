<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Port extends Model
{
    use HasFactory;

    protected $table = 'puertos';

    protected $fillable = ['name', 'location', 'reception_capacity'];

    public function maritimeShipments()
    {
        return $this->hasMany(MaritimeShipment::class);
    }
}

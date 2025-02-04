<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CustomerType extends Model
{
    use HasFactory;

    protected $table = 'tipos_clientes';

    protected $fillable = ['tipo'];

    public function customers()
    {
        return $this->hasMany(Customer::class);
    }
}
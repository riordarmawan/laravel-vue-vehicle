<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Vehicle extends Model
{
    use HasFactory;
    protected $connection = 'pgsql';
    protected $table = 'public.vehicles';
    public $timestamps = false;
    protected $fillable = ['brand', 'name', 'price', 'seat', 'transmission', 'type'];
}

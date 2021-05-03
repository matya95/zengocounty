<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class County extends Model
{
    use HasFactory;
    protected $table='counties';
    protected $primaryKey = 'id';
    public $timestamps=false;
    public $incrementing = true;


    public function hasCities(){

        return $this->hasMany(City::class);
    }
}

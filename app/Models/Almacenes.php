<?php

namespace App\Models;

use App\Models\Productos;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Almacenes extends Model
{
    use HasFactory;

    protected $table = 'almacenes';

    protected $primaryKey = 'id';

    protected $keyType = 'int';

    public $incrementing = true;

    public $fillable = [
        'nombre'
    ];

    public $hidden = [
        'created_at',
        'updated_at'
    ];

    public function productos()
    {
        return $this->hasMany(Productos::class, 'id_almacen');
    }
}

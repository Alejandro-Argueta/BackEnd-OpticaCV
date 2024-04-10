<?php

namespace App\Models;

use App\Models\Almacenes;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Productos extends Model
{
    use HasFactory;

    protected $table = 'productos';

    protected $primaryKey = 'id';

    protected $keyType = 'int';

    public $incrementing = true;

    public $fillable = [
        'nombre',
        'descripcion',
        'precio',
        'cantidad',
        'id_almacen'
    ];

    public $hidden = [
        'created_at',
        'updated_at'
    ];

    public function almacen()
    {
        return $this->belongsTo(Almacenes::class, 'id_almacen');
    }
}

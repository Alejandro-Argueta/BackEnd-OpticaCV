<?php

namespace App\Http\Controllers;

use Exception;
use App\Models\Productos;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;

class ProductosController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        try {
            $productos = Productos::with('almacen')->get();
            return response()->json(['productos' => $productos], 200);
        } catch (Exception $e) {
            return response()->json(['Message' => $e->getMessage()], 500);
        }
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        try {
            $rules = [
                "nombre" => ['required', 'max:50'],
                "descripcion" => ['required', 'max:200'],
                "precio" => ['required', 'numeric'],
                "cantidad" => ['required', 'integer'],
                'id_almacen' => ['required', 'integer', Rule::exists('almacenes', 'id')],
            ];

            $messages = [
                'required' => 'El valor del :attribute es necesario',
                'numeric' => 'El formato de:attribute es irreconocible.',
                'integer' => 'El formato de:attribute es irreconocible.',
                'exists' => ':attribute no existe o esta inactivo.',
            ];

            $attributes = [
                'nombre' => 'Nombre',
                'descripcion' => 'Descripcion',
                'precio' => 'Precio de Producto',
                'cantidad' => 'Cantidad de Almacen',
                'id_almacen' => 'Identificador Almacen',
            ];

            $request->validate($rules, $messages, $attributes);

            $producto = [
                'nombre' => $request->nombre,
                'descripcion' => $request->descripcion,
                'precio' => $request->precio,
                'cantidad' => $request->cantidad,
                'id_almacen' => $request->id_almacen
            ];

            Productos::create($producto);

            return response()->json(['Message' => 'Producto Registrado'], 200);
        } catch (ValidationException $e) {
            return response()->json(['Errors' => $e->validator->errors()->getMessages()], 400);
        } catch (Exception $e) {
            return response()->json(['Message' => $e->getMessage()], 500);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(int $id)
    {
        
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, int $id)
    {
        try {
            $rules = [
                'id' => ['required', 'integer', Rule::exists('productos', 'id'), Rule::in([$id])],
                "nombre" => ['required', 'max:50'],
                "descripcion" => ['required', 'max:200'],
                "precio" => ['required', 'numeric'],
                "cantidad" => ['required', 'integer'],
                'id_almacen' => ['required', 'integer', Rule::exists('almacenes', 'id')],
            ];

            $messages = [
                'id.in' => 'El ID no coincide con el registro a modificar.',
                'required' => 'El valor del :attribute es necesario',
                'numeric' => 'El formato de:attribute es irreconocible.',
                'integer' => 'El formato de:attribute es irreconocible.',
                'exists' => ':attribute no existe o esta inactivo.',
            ];

            $attributes = [
                'id' => 'Identificador',
                'nombre' => 'Nombre',
                'descripcion' => 'Descripcion',
                'precio' => 'Precio de Producto',
                'cantidad' => 'Cantidad de Almacen',
                'id_almacen' => 'Identificador Almacen',
            ];

            $request->validate($rules, $messages, $attributes);

            $producto = Productos::findOrFail($request->id);

            $productoData = [
                'nombre' => $request->nombre,
                'descripcion' => $request->descripcion,
                'precio' => $request->precio,
                'cantidad' => $request->cantidad,
                'id_almacen' => $request->id_almacen
            ];

            $producto->update($productoData);

            return response()->json($producto, 200);
        } catch (ValidationException $e) {
            return response()->json(['Errors' => $e->validator->errors()->getMessages()], 400);
        } catch (Exception $e) {
            return response()->json(['Message' => $e->getMessage()], 500);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        try {
            $validate = Validator::make(
                ['id' => $id],
                [
                    'id' => [
                        'required',
                        'integer',
                        Rule::exists(
                            'productos',
                            'id'
                        )
                    ]
                ],
                [
                    'id.required' => 'Falta :attribute.',
                    'id.integer' => ':attribute irreconocible.',
                    'id.exists' => ':attribute No se ha encontrado.',
                ],
                ['id' => 'Identificador de Producto'],
            )->validate();

            $producto = null;

            DB::transaction(function () use ($validate, &$producto) {
                $producto = Productos::findOrFail($validate['id']);
                $producto->delete();
                $producto['status'] = 'deleted';
            });

            return response()->json($producto, 200);
        } catch (ValidationException $e) {
            return response()->json(['Errors' => $e->validator->errors()->getMessages()], 400);
        } catch (Exception $e) {
            return response()->json(['Message' => $e->getMessage()], 500);
        }
    }
}

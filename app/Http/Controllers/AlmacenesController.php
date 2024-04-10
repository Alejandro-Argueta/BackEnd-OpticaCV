<?php

namespace App\Http\Controllers;

use Exception;
use App\Models\Almacenes;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;

class AlmacenesController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        try {
            $almacenes = Almacenes::all();
            return response()->json(['almacenes' => $almacenes], 200);
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
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(int $id)
    {
        try{
            $validate = Validator::make(
                ['id' => $id],
                [
                    'id' => [
                        'required',
                        'integer',
                        Rule::exists(
                            'almacenes',
                            'id'
                        )
                    ]
                ],
                [
                    'id.required' => 'Falta :attribute.',
                    'id.integer' => ':attribute irreconocible.',
                    'id.exists' => ':attribute No se ha encontrado.',
                ],
                ['id' => 'Identificador de Almacen'],
            )->validate();

            $almacen = Almacenes::with('productos')->findOrFail($validate['id']);

            return response()->json($almacen, 200);

        }catch(ValidationException $e){
            return response()->json(['Errors' => $e->validator->errors()->getMessages()],400);
        }catch(Exception $e){
            return response()->json(['Message' => $e->getMessage()],500);
        }
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
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}

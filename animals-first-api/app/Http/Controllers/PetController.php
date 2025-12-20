<?php

namespace App\Http\Controllers;

use App\Models\Pet;
use Illuminate\Http\Request;

class PetController extends Controller
{
    public function index()
    {
        $pets = Pet::all();

        return response()->json($pets);
    }
    
    public function show(string $id)
    {
        $pet = Pet::find($id);

        if (!$pet) {
            return response()->json([
                'message' => 'Pet not found'
            ], 404);
        }

        return response()->json($pet);
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'name'     => ['required', 'string'],
            'species'  => ['required', 'string'],
            'age'      => ['nullable', 'integer'],
            'adopted'  => ['required', 'boolean'],
            'location' => ['required', 'string'],
            'gender'   => ['required', 'string', 'in:male,female'],
            'breed'    => ['nullable', 'string'],
        ]);

        $pet = Pet::create($data);

        return response()->json($pet, 201);
    }

    public function update(Request $request, string $id)
    {
        $pet = Pet::find($id);

        if (!$pet) {
            return response()->json([
                'message' => 'Pet not found'
            ], 404);
        }

        $data = $request->validate([
            'name'     => ['sometimes', 'string'],
            'species'  => ['sometimes', 'string'],
            'age'      => ['sometimes', 'integer'],
            'adopted'  => ['sometimes', 'boolean'],
            'location' => ['sometimes', 'string'],
            'gender'   => ['sometimes', 'string'],
            'breed'    => ['sometimes', 'string'],
        ]);

        $pet->update($data);

        return response()->json($pet,201);
    } 

    public function destroy(string $id)
    {
        $pet = Pet::find($id);

        if (!$pet) {
            return response()->json([
                'message' => 'Pet not found'
            ], 404);
        }

        $pet->delete();

        return response()->json(null, 204);
    }
}

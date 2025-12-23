<?php

namespace App\Http\Controllers;

use App\Models\Pet;
use Illuminate\Http\Request;

class PetAdoptionController extends Controller
{
    public function adopt(string $id, Request $request)
    {
        $data = $request->validate([
            'fullName' => ['required', 'string', 'max:180'],
            'email' => ['required', 'email', 'max:180'],
            'phone' => ['required', 'string', 'max:30'],
            'dob' => ['required', 'date'],
            'address1' => ['required', 'string', 'max:180'],
            'address2' => ['nullable', 'string', 'max:180'],
            'city' => ['required', 'string', 'max:120'],
            'state' => ['required', 'string', 'size:2'],
            'zip' => ['required', 'string', 'max:10'],
            'housingType' => ['required', 'string'],
            'renting' => ['required', 'in:Yes,No'],
            'petsAllowed' => ['required', 'in:Yes,No'],
            'householdAdults' => ['required', 'integer', 'min:1'],
            'householdChildren' => ['required', 'integer', 'min:0'],
            'currentPets' => ['nullable', 'string'],
            'vetName' => ['nullable', 'string'],
            'ackResponsibleOwnership' => ['required', 'boolean'],
            'ackHousingPolicy' => ['required', 'boolean'],
            'ackSpayNeuter' => ['required', 'boolean'],
        ]);

        $pet = Pet::find($id);

        if (!$pet) {
            return response()->json([
                'message' => 'Pet Not Found'
            ], 404);
        }

        if ($pet->adopted === true) {
            return response()->json([
                'message' => 'Pet Already Adopted'
            ], 409);
        }

        $pet->update([
            'adopted' => true,
            'adoption' => $data,
        ]);

        return response()->json([
            'message' => 'Adoption saved!',
            'pet' => $pet,
        ], 201);
    }
}

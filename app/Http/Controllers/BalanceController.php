<?php

namespace App\Http\Controllers;


use App\Models\User;
use Illuminate\Http\Request;


class BalanceController extends Controller
{
    public function show(Request $request)
    {
        // chequear si el usuario es una cadena de caracteres
        $name = $request->input('name');
        if (is_string($name)) {
            $accountName = $request->input('name');
            $user = User::where('name', $accountName)->first();
            if ($user) {
                return response()->json([
                    'message' => 'Balance',
                    'name' => $user->name,
                    'Creditos' => $user->creditos
                ]);
            } else {
                return response()->json([
                    'message' => 'No existe el usuario'
                ]);
            }
        } elseif (is_numeric($name)) {
            return response()->json([
                'message' => 'El nombre debe ser una cadena de caracteres'
            ], 400);
        }else{
            return response()->json([
                'message' => 'Los datos ingresados no son validos'
            ], 400);
        }
        
        


    }
}

<?php

namespace App\Http\Controllers;


use App\Models\User;
use Illuminate\Http\Request;


class BalanceController extends Controller
{
    public function show(Request $request)
    {
        $accountName = $request->input('name');
        $user = User::where('name', $accountName)->first();
        if ($user) {
            return response()->json([
                'message' => 'Balance',
                'account' => $user->creditos
            ]);
        } else {
            return response()->json([
                'message' => 'No existe el usuario'
            ]);
        }
        
        


    }
}

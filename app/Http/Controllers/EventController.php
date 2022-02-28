<?php

namespace App\Http\Controllers;

use App\Models\Recarga;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\User;




class EventController extends Controller
{
    public function deposit(Request $request){
        //realizar un deposito de los creditos para realizar una recarga
        //ingresar el nombre del usuario y la cantidad de creditos en la opcion "body" de postman
        $user = User::where('name', $request->input('name'))->first();
        $user->creditos += $request->input('creditos');
        $user->save();
        return response()->json([
            'message' => 'Deposito realizado con exito',
            'user' => $user
        ]);

    }

    public function crearUsuario(Request $request){
        //guardar nuevo usuario en la base de datos
        //ingresar los datos en la opcion "body" de postman
        // crear nuevo registro de user con credito de 100
        $user = new User();
        $user->name = $request->input('name');
        $user->creditos = 100;
        $user->save();
        return response()->json([
            'message' => 'Usuario creado con exito',
            'user' => $user
        ]);

    }

    public function  recarga(Request $request){
        //se realiza una recarga telefonica
        //ingresar el nombre del usuario y la cantidad de creditos en la opcion "body" de postman
        $user = User::where('name', $request->input('name'))->first();
        //verificar si existe el usuario
        if($user){
            if ($request->input('creditos') > $user->creditos) {
                return response()->json([
                    'message' => 'No hay suficientes creditos, realice un deposito'
                ]);
            }else{
                DB::transaction(function () use ($user, $request) {
                    $user->creditos -= $request->input('creditos');
                    //insertar en la tabla recarga numero de telefono, cantidad de creditos y nombre del usuario
                    Recarga::create([
                        'numero' => $request->input('numero'),
                        'cantidad' => $request->input('creditos'),
                        'usuario' => $user->name
                    ]);
                    $user->save();
                });
                //mostrar el ultimo registro de la tabla recarga
                $recarga = Recarga::orderBy('id', 'desc')->first();
                return response()->json([
                    'message' => 'Recarga realizada con exito',
                    'user' => $user,
                    'recarga' => $recarga
                ]);
            }
        }else {
            return response()->json([
                'message' => 'Usuario no existe'
            ]);
        }

    }
}

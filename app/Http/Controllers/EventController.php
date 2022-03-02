<?php

namespace App\Http\Controllers;

use App\Models\Recarga;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\User;




class EventController extends Controller
{
    public function deposit(Request $request){
        //*verificado 
        //realizar un deposito de los creditos para realizar una recarga
        //ingresar el nombre del usuario y la cantidad de creditos en la opcion "body" de postman
        
        $creditos = $request->input('creditos');
        $name = $request->input('name');
        if (is_string($name) && is_numeric($creditos)) {
            if ($request->input('creditos') > 0) {
                $user = User::where('name', $name)->first();
                if ($user) {
                    $user->creditos = $user->creditos + $creditos;
                    $user->save();
                    return response()->json([
                        'message' => 'Deposito realizado con exito',
                        'cuenta' => $user->name,
                        'creditos' => $user->creditos
                    ]);
                } else {
                    return response()->json([
                        'message' => 'No existe el usuario'
                    ], 404);
                }
            }else{
                return response()->json([
                    'message' => 'No se puede realizar una recarga con valor negativo'
                ], 400);
            }
            
        }elseif (is_numeric($name)) {
            return response()->json([
                'message' => 'El nombre debe ser una cadena de caracteres'
            ], 400);
        }elseif(is_string($creditos)){
            return response()->json([
                'message' => 'Los creditos deben ser un numero'
            ], 400);
        }else{
            return response()->json([
                'message' => 'Los datos ingresados no son validos'
            ], 405);
        }
        
    }

    public function crearUsuario(Request $request){
        //*verificado
        //guardar nuevo usuario en la base de datos
        //ingresar los datos en la opcion "body" de postman
        $name = $request->input('name');
        if (is_string($name)) {
            $existe = User::where('name', $request->input('name'))->first();
            if ($existe) {
                return response()->json([
                    'message' => 'El usuario ya existe'
                ], 219);
            }else{
                DB::transaction(function () use ($user, $request) {
                    $user = new User();
                    $user->name = $request->input('name');
                    $user->creditos = 100;
                    $user->save();
                    return response()->json([
                    'message' => 'Usuario creado con exito',
                    'user' => $user
                    ]);
                });
            }
        }elseif(is_numeric($name)){
            return response()->json([
                'message' => 'El nombre debe ser una cadena de caracteres'
            ], 400);
        }else{
            return response()->json([
                'message' => 'Los datos ingresados no son validos'
            ], 405);
        }


    }

    public function  recarga(Request $request){
        //*verificado
        //se realiza una recarga telefonica
        //ingresar el nombre del usuario y la cantidad de creditos en la opcion "body" de postman
        $name = $request->input('name');
        $numero = $request->input('numero');
        $creditos = $request->input('creditos');
        if (is_string($name) && is_numeric($creditos) && is_numeric($numero)) {
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
                        'nombre' => $recarga->usuario,
                        'numero' => $recarga->numero,
                        'cantidad' => $recarga->cantidad
                    ]);
                }
            }else {
                return response()->json([
                    'message' => 'Usuario no existe'
                ], 404);
            }
        }elseif(is_string($numero)){
            return response()->json([
                'message' => 'El numero debe ser una cadena de numeros'
            ], 400);
        }elseif (is_numeric($name)) {
            return response()->json([
                'message' => 'El nombre debe ser una cadena de caracteres'
            ], 400);
        }elseif(is_string($creditos)){
            return response()->json([
                'message' => 'Los creditos deben ser un numero'
            ], 400);
        }else{
            return response()->json([
                'message' => 'Los datos ingresados no son validos'
            ], 405);
        }
    }
    
}

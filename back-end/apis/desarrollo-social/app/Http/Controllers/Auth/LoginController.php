<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\Gds\DiDirecciones;
use App\Models\Gds\Usuario;
use App\Rules\ValidateCui;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Facades\Hash;

class LoginController extends Controller
{
    public function authenticate(Request $request) {
        $request->validate([
            'cui' => ['required','numeric','digits:13',new ValidateCui,'exists:usuarios,cui'],
            'password' => 'required|string|min:8'
        ]);

        try {

            $aud = $request->header('Origin');
            $receivers = config('jwt.receivers');

            if(in_array($aud,$receivers)){

                $user = Usuario::where('cui',$request->cui)->first();
                $user->makeVisible('password');

            
                if(Hash::check($request->password,$user->password)){

                    $user->makeHidden('password');

                    $escuela = DiDirecciones::withCount('escuelas')->where('id',$user->empleado->di_direccion_id)->first();
                    
                    
                    if($escuela->escuelas_count > 0 ) {
                        $user->escuelas = true;
                    }

                    Auth::login($user);
                    
                    $payload = [
                        'sub' => $user->id,
                    ];

                    $accessToken = $user->createToken($payload, $aud);

                    if($accessToken) {

                        $cookie = cookie('access_token', $accessToken, config('jwt.expired_token'), '/', null, null, false);
        
                        return response(base64_encode(
                            $this->permisosApp(
                                $user->load(
                                    'roles.permisos',
                                    'empleado:id,primer_nombre,primer_apellido,di_direccion_id'
                                ),
                                $request->header('App')
                            )
                        ))->withCookie($cookie);
                    }

                    return response('Unauthorized',422);
                }
            }

            return response(['errors' => ['credenciales' => ['Credenciales invalidas']] ], 422);

        } catch (\Throwable $th) {
            return response($th->getMessage());
        }

        
    }

    public function verifyAuth(Request $request) {

        $user = auth()->user()->load(
            'roles.permisos',
            'empleado:id,primer_nombre,primer_apellido,di_direccion_id'
        );

        
        $user = $this->permisosApp($user,$request->header('App'));

        return response(base64_encode($user));

    }

    public function permisosApp($user, $app) {

        $user = $user;

        if( isset($user->roles) && count($user->roles) > 0 ){

            $roles = $user->roles->filter(function($role) use($app) {
                $permisos = $role->permisos->map(function($permiso){
                    return ['id' => $permiso->id,'nombre' => $permiso->nombre ];
                });

                unset($role->permisos);
                unset($role->pivot);

                $role['permisos'] = $permisos;

                return $role->app == $app;

            })->values();


            unset($user->roles);
            $user['roles'] = $roles;
        }

        return $user;
    }

    public function logout() {
        Auth::logout();
        $cookie = Cookie::forget('access_token');
        return response(['message' => 'Successfully logged out'])
                         ->withCookie($cookie);
    }
}

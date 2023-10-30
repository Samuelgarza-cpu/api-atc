<?php

namespace App\Http\Controllers;


use App\Http\Controllers\Controller;
use App\Models\ObjResponse;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;


class UserController extends Controller
{

   /**
    * Metodo para validar credenciales e
    * inicar sesión
    * @param Request $request
    * @return \Illuminate\Http\Response $response
    */
   public function login(Request $request, Response $response)
   {
      try {
         $field = 'email';
         $value = $request->email;

         $request->validate([
            $field => 'required',
            'password' => 'required'
         ]);
         $user = User::where("$field", "$value")->first();

         if (!$user || !Hash::check($request->password, $user->password)) {
            $response->data = ObjResponse::DefaultResponse();
            $response->data["message"] = 'Datos Incorrectos';
            return response()->json($response, $response->data["status_code"]);
         } else {
            $token = $user->createToken($request->email)->plainTextToken;
            $response->data = ObjResponse::CorrectResponse();
            $response->data["message"] = 'peticion satisfactoria | usuario logeado.';
            $response->data["result"] = $user;
            $response->data["result"]["token"] = $token;
            return response()->json($response, $response->data["status_code"]);
         }
      } catch (\Exception $error) {

         return $error->getMessage();
      }
   }

   /**
    * Metodo para cerrar sesión.
    * @param int $id
    * @return \Illuminate\Http\Response $response
    */
   public function logout(Response $response, $id,)
   {
      try {


         auth()->user()->tokens()->delete();
         // DB::connection('mysql_gomezapp')->table('personal_access_tokens')->where('tokenable_id', $id)->delete();

         $response->data = ObjResponse::CorrectResponse();
         $response->data["message"] = 'peticion satisfactoria | sesión cerrada.';
         $response->data["alert_title"] = "Bye!";
      } catch (\Exception $ex) {
         $response->data = ObjResponse::CatchResponse($ex->getMessage());
      }
      return response()->json($response, $response->data["status_code"]);
   }

   /**
    * Reegistrarse como ciudadano desde la app.
    *
    * @param  \Illuminate\Http\Request $request
    * @return \Illuminate\Http\Response $response
    */
   public function signup(Request $request, Response $response)
   {

      $response->data = ObjResponse::DefaultResponse();
      try {

         // if (!$this->validateAvailability('username',$request->username)->status) return;

         $new_user = User::create([

            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role_id' => 3, //usuario normal
            'phone' => $request->phone,
            'name' => $request->name,
            'paternal_last_name' => $request->paternal_last_name,
            'maternal_last_name' => $request->maternal_last_name,
            'department_id' => 1,

         ]);
         $response->data = ObjResponse::CorrectResponse();
         $response->data["message"] = 'peticion satisfactoria | usuario registrado.';
         $response->data["alert_text"] = "¡Felicidades! ya eres parte de la familia";
      } catch (\Exception $ex) {
         $response->data = ObjResponse::CatchResponse($ex->getMessage());
      }
      return response()->json($response, $response->data["status_code"]);
   }


   /**
    * Mostrar lista de usuarios activos del
    * uniendo con roles.
    *
    * @return \Illuminate\Http\Response $response
    */
   public function index(Response $response)
   {
      $response->data = ObjResponse::DefaultResponse();
      try {

         $list = User::where('active', true)->get();

         $response->data = ObjResponse::CorrectResponse();
         $response->data["message"] = 'peticion satisfactoria | lista de usuarios.';
         $response->data["alert_text"] = "usuarios encontrados";
         $response->data["result"] = $list;
      } catch (\Exception $ex) {
         $response->data = ObjResponse::CatchResponse($ex->getMessage());
      }
      return response()->json($response, $response->data["status_code"]);
   }

   /**
    * Mostrar listado para un selector.
    *
    * @return \Illuminate\Http\Response $response
    */
   public function selectIndex(Response $response)
   {
      $response->data = ObjResponse::DefaultResponse();
      try {
         $list = User::where('active', true)
            ->select('users.id as value', 'users.username as text')
            ->orderBy('users.username', 'asc')->get();
         $response->data = ObjResponse::CorrectResponse();
         $response->data["message"] = 'peticion satisfactoria | lista de usuarios.';
         $response->data["alert_text"] = "usuarios encontrados";
         $response->data["result"] = $list;
         $response->data["toast"] = false;
      } catch (\Exception $ex) {
         $response->data = ObjResponse::CatchResponse($ex->getMessage());
      }
      return response()->json($response, $response->data["status_code"]);
   }

   /**
    * Crear usuario.
    *
    * @param  \Illuminate\Http\Request $request
    * @return \Illuminate\Http\Response $response
    */
   public function create(Request $request, Response $response)
   {
      $response->data = ObjResponse::DefaultResponse();
      try {
         $token = $request->bearerToken();

         $existUser = User::where("email", $request->email)->first();


         if ($request->role_id <= 2) {


            $new_user = new User;
            $new_user->email =  $request->email;
            $new_user->password =  Hash::make($request->password);
            $new_user->role_id =  $request->role_id;
            $new_user->save();
         } else {
            $new_user = new User;

            $new_user->email = $request->email;
            $new_user->password = Hash::make($request->password);
            $new_user->role_id = $request->role_id;
            $new_user->phone = $request->phone;
            $new_user->name = $request->name;
            $new_user->paternal_last_name = $request->paternal_last_name;
            $new_user->maternal_last_name = $request->maternal_last_name;
            $new_user->save();
         }
         $response->data = ObjResponse::CorrectResponse();
         $response->data["message"] = 'peticion satisfactoria | usuario registrado.';
         $response->data["alert_text"] = "Usuario registrado";
      } catch (\Exception $ex) {
         $response->data = ObjResponse::CatchResponse($ex->getMessage());
      }
      return response()->json($response, $response->data["status_code"]);
   }

   /**
    * Mostrar usuario.
    *
    * @param   int $id
    * @param  \Illuminate\Http\Request $request
    * @return \Illuminate\Http\Response $response
    */
   public function show(Request $request, Response $response)
   {
      $response->data = ObjResponse::DefaultResponse();
      try {
         // echo "el id: $request->id";
         $user = User::where('users.id', $request->id)->first();

         $response->data = ObjResponse::CorrectResponse();
         $response->data["message"] = 'peticion satisfactoria | usuario encontrado.';
         $response->data["alert_text"] = "Usuario encontrado";
         $response->data["result"] = $user;
      } catch (\Exception $ex) {
         $response = ObjResponse::CatchResponse($ex->getMessage());
      }
      return response()->json($response, $response->data["status_code"]);
   }

   /**
    * Actualizar usuario.
    *
    * @param  \Illuminate\Http\Request $request
    * @return \Illuminate\Http\Response $response
    */
   public function update(Request $request, Response $response)
   {
      $response->data = ObjResponse::DefaultResponse();
      try {
         // echo "el id: $request->id";
         if ($request->role_id < 2) {
            $user = User::find($request->id)
               ->update([

                  'email' => $request->email,
                  'password' => Hash::make($request->password),
                  'role_id' => $request->role_id,

               ]);
         } else {
            $user = User::find($request->id)
               ->update([

                  'email' => $request->email,
                  'password' => Hash::make($request->password),
                  'role_id' => $request->role_id,
                  'phone' => $request->phone,
                  'name' => $request->name,
                  'paternal_last_name' => $request->paternal_last_name,
                  'maternal_last_name' => $request->maternal_last_name,
               ]);
         }

         $response->data = ObjResponse::CorrectResponse();
         $response->data["message"] = 'peticion satisfactoria | usuario actualizado.';
         $response->data["alert_text"] = "Usuario actualizado";
      } catch (\Exception $ex) {
         $response->data = ObjResponse::CatchResponse($ex->getMessage());
      }
      return response()->json($response, $response->data["status_code"]);
   }

   /**
    * "Eliminar" (cambiar estado activo=false) usuario.
    *
    * @param  int $id
    * @return \Illuminate\Http\Response $response
    */
   public function destroy(int $id, Response $response)
   {
      $response->data = ObjResponse::DefaultResponse();
      try {
         $destroy = User::find($id);

         $destroy->active = false;
         $destroy->deleted_at = date('Y-m-d H:i:s');
         $destroy->save();

         $response->data = ObjResponse::CorrectResponse();
         $response->data["message"] = 'peticion satisfactoria | usuario eliminado.';
         $response->data["alert_text"] = "Usuario eliminado";
      } catch (\Exception $ex) {
         $response->data = ObjResponse::CatchResponse($ex->getMessage());
      }
      return response()->json($response, $response->data["status_code"]);
   }



   // private function validateAvailability(string $prop, int $value, string $message_error)
   // {
   //     $response->data = ObjResponse::DefaultResponse();
   //     data_set($response,'alert_text',$message_error);
   //     try {
   //         $exist = User::where($prop, $value)->count();

   //         if ($exist > 0) $response = ObjResponse::CorrectResponse();

   //     } catch (\Exception $ex) {
   //         $response = ObjResponse::CatchResponse($ex->getMessage());
   //     }
   //     return response()->json($response,$response["status_code"]);
   // }
}

<?php

namespace App\Http\Controllers;


use App\Http\Controllers\Controller;
use App\Mail\RecuperarContraseña;
use App\Models\ObjResponse;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Validation\ValidationException;


class UserController extends Controller
{

   public function login(Request $request, Response $response)
   {
      try {
         $field = 'email';
         $value = $request->email;

         $request->validate([
            $field => 'required',
            'password' => 'required'
         ]);
         $user = User::where("$field", "$value")
            ->where('active', true)
            ->first();

         if (!$user || !Hash::check($request->password, $user->password)) {
            $response->data = ObjResponse::DefaultResponse();
            $response->data["message"] = 'Datos Incorrectos';
            return response()->json($response, $response->data["status_code"]);
         } else {
            $token = $user->createToken($request->email)->plainTextToken;
            $response->data = ObjResponse::CorrectResponse();
            $response->data["message"] = 'peticion satisfactoria | usuario logeado.';
            $response->data["alert_text"] = 'BIENVENIDO';
            $response->data["result"] = $user;
            $response->data["result"]["token"] = $token;
            return response()->json($response, $response->data["status_code"]);
         }
      } catch (\Exception $error) {

         return $error->getMessage();
      }
   }
   public function recovery(Request $request, Response $response)
   {
      try {

         $email = $request->email;

         $request->validate([
            'email' => 'required'
         ]);
         $user = User::where("email", $email)->first();

         if (!$user) {
            $response->data = ObjResponse::DefaultResponse();
            $response->data["message"] = 'Correo NO encontrado';
            $response->data["alert_text"] = 'Correo NO encontrado';
            return response()->json($response, $response->data["status_code"]);
         } else {

            $longitud_cadena = 8;
            $caracteres_alfabeticos = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ%$&?¡';
            $caracter_alfabetico = $caracteres_alfabeticos[mt_rand(0, strlen($caracteres_alfabeticos) - 1)];
            $numeros = mt_rand(pow(10, $longitud_cadena - 2), pow(10, $longitud_cadena - 1) - 1);
            $cadena_aleatoria = $caracter_alfabetico . $numeros;
            $dataOut = [
               "email" =>  $email,
               "password" => $cadena_aleatoria,

            ];

            $updatePass = User::where('email', $email)->first();
            $updatePass->password = Hash::make($cadena_aleatoria);;
            $updatePass->updated_at = date('Y-m-d H:i:s');
            $updatePass->save();

            $response->data = ObjResponse::CorrectResponse();
            $response->data["message"] = 'peticion satisfactoria ';
            $response->data["alert_text"] = 'Contraseña enviada correctamente, revisar correo de 5 - 10 min ';
            $envio = Mail::to($email)->send(new RecuperarContraseña($dataOut));
            // $response->data["result"] = $cadena_aleatoria;

            return response()->json($response, $response->data["status_code"]);
         }
      } catch (\Exception $error) {

         return $error->getMessage();
      }
   }
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

   public function index(Response $response)
   {
      $response->data = ObjResponse::DefaultResponse();
      try {

         $list = User::where('users.active', true)
            // ->join('roles', 'role_id', '=', 'roles.id')
            ->get();

         $response->data = ObjResponse::CorrectResponse();
         $response->data["message"] = 'peticion satisfactoria | lista de usuarios.';
         $response->data["alert_text"] = "usuarios encontrados";
         $response->data["result"] = $list;
      } catch (\Exception $ex) {
         $response->data = ObjResponse::CatchResponse($ex->getMessage());
      }
      return response()->json($response, $response->data["status_code"]);
   }

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

   public function create(Request $request, Response $response)
   {


      $response->data = ObjResponse::DefaultResponse();
      try {
         // $token = $request->bearerToken();

         $existUser = User::where("email", $request->email)->first();

         if ($existUser != "") {
            $response->data = ObjResponse::CorrectResponse();
            $response->data["message"] = 'peticion satisfactoria';
            $response->data["alert_text"] = "Correo ya registrado, intenta con otro";
            $response->data['status_code'] = 403;
         } else {

            $new_user = new User;

            $new_user->email = $request->email;
            $new_user->password = Hash::make($request->password);
            $new_user->role_id = $request->role_id;
            $new_user->phone = $request->phone;
            $new_user->name = $request->name;
            $new_user->paternal_last_name = $request->paternal_last_name;
            $new_user->maternal_last_name = $request->maternal_last_name;
            $new_user->curp = $request->curp == "" ? "" : $request->curp;
            $new_user->sexo = $request->sexo == "" ? "" : $request->sexo;
            $new_user->save();

            $response->data = ObjResponse::CorrectResponse();
            $response->data["message"] = 'peticion satisfactoria | usuario registrado.';
            $response->data["alert_text"] = "Usuario registrado";
         }
      } catch (\Exception $ex) {
         $response->data = ObjResponse::CatchResponse($ex->getMessage());
      }
      return response()->json($response, $response->data["status_code"]);
   }

   public function show(Request $request, Response $response, $id)
   {
      $response->data = ObjResponse::DefaultResponse();
      try {
         // echo "el id: $request->id";
         $user = User::where('users.id', $id)
            // ->join('roles', 'role_id', '=', 'roles.id')
            ->first();

         $response->data = ObjResponse::CorrectResponse();
         $response->data["message"] = 'peticion satisfactoria | usuario encontrado.';
         $response->data["alert_text"] = "Usuario encontrado";
         $response->data["result"] = $user;
      } catch (\Exception $ex) {
         $response = ObjResponse::CatchResponse($ex->getMessage());
      }
      return response()->json($response, $response->data["status_code"]);
   }

   public function update(Request $request, Response $response)
   {
      $response->data = ObjResponse::DefaultResponse();
      try {


         $user = User::find($request->id)
            ->update([

               'email' => $request->email,
               'role_id' => $request->role_id,
               'phone' => $request->phone,
               'name' => $request->name,
               'paternal_last_name' => $request->paternal_last_name,
               'maternal_last_name' => $request->maternal_last_name,
               'sexo' => $request->sexo,
               'curp' => $request->curp,
               'updated' => date('Y-m-d H:i:s')
            ]);


         $response->data = ObjResponse::CorrectResponse();
         $response->data["message"] = 'peticion satisfactoria | usuario actualizado.';
         $response->data["alert_text"] = "Usuario actualizado";
      } catch (\Exception $ex) {
         $response->data = ObjResponse::CatchResponse($ex->getMessage());
      }
      return response()->json($response, $response->data["status_code"]);
   }

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

   public function updatePassword(Request $request, Response $response, $id)
   {
      $response->data = ObjResponse::DefaultResponse();
      try {
         $updatePass = User::find($id);

         $updatePass->password = Hash::make($request->password);;
         $updatePass->updated_at = date('Y-m-d H:i:s');
         $updatePass->save();

         $response->data = ObjResponse::CorrectResponse();
         $response->data["message"] = 'peticion satisfactoria | Contraseña Actualizada';
         $response->data["alert_text"] = "Contraseña Actualizada";
      } catch (\Exception $ex) {
         $response->data = ObjResponse::CatchResponse($ex->getMessage());
      }
      return response()->json($response, $response->data["status_code"]);
   }
}

<?php

namespace App\Http\Controllers\GomezApp;

use App\Http\Controllers\Controller;
use App\Models\GomezApp\SParticular;
use App\Models\GomezApp\SpRequests;
use App\Models\ObjResponse;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class SParticularController extends Controller
{


    public function index(Request $request, Response $response)
    {
        $data = SpRequests::all();
        return response()->json($data);
    }
    public function store(Request $request, Response $response)
    {

        $request->validate([
            'observaciones' => 'required|string|max:255',
            'calle' => 'required|string|max:255',
            'id_departamento_destino' => 'required',
            'id_asunto' => 'required'
        ]);

        $longitud_cadena = 5;
        $caracteres_alfabeticos = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $caracter_alfabetico = $caracteres_alfabeticos[mt_rand(0, strlen($caracteres_alfabeticos) - 1)];
        $numeros = mt_rand(pow(10, $longitud_cadena - 2), pow(10, $longitud_cadena - 1) - 1);
        $cadena_aleatoria = $caracter_alfabetico . $numeros;
        try {
            $response->data = ObjResponse::DefaultResponse();
            $reports = new SParticular;
            $reports->fecha_solicitud = date('Y-m-d');
            $reports->folio =  $cadena_aleatoria;
            $reports->nombre =  $request->nombre;
            $reports->app =  $request->app;
            $reports->apm =  $request->apm;
            $reports->telefono =  $request->telefono;
            $reports->calle = $request->calle;
            $reports->num_ext = $request->num_ext;
            $reports->num_int = $request->num_int;
            $reports->cp = $request->cp;
            $reports->colonia = $request->colonia;
            $reports->localidad = $request->localidad;
            $reports->estado = $request->estado;
            $reports->id_departamento_destino = $request->id_departamento_destino;
            $reports->id_asunto = $request->id_asunto;
            $reports->observaciones = $request->observaciones;
            $reports->id_user_create = $request->id_user_create;
            $reports->id_estatus = 1;
            $reports->save();


            $response->data = ObjResponse::CorrectResponse();
            $response->data["message"] = 'peticion satisfactoria | usuario eliminado.';
            $response->data["alert_text"] = "Respuesta enviada";
            $response->data["result"] = ["se registro respuesta" =>  $reports];
        } catch (\Exception $ex) {
            $response->data = ObjResponse::CatchResponse($ex->getMessage());
        }
        return response()->json($response, $response->data["status_code"]);
    }
    public function destroy(Request $request, Response $response, $id)
    {
        $response->data = ObjResponse::DefaultResponse();
        try {
            $deleteReport = SParticular::find($id);
            $deleteReport->active = 0;
            $deleteReport->deleted_at = now();
            $deleteReport->save();

            $response->data = ObjResponse::CorrectResponse();
            $response->data["message"] = 'peticion satisfactoria | usuario eliminado.';
            $response->data["alert_text"] = "Usuario eliminado";
        } catch (\Exception $ex) {
            $response->data = ObjResponse::CatchResponse($ex->getMessage());
        }
        return response()->json($response, $response->data["status_code"]);
    }
    public function show(Response $response, $id)
    {
        $response->data = ObjResponse::DefaultResponse();
        try {
            $list = SpRequests::where("id", $id)->first();
            $response->data = ObjResponse::CorrectResponse();
            $response->data["message"] = 'Peticion satisfactoria | Lista de mis reportes.';
            $response->data["result"] = $list;
        } catch (\Exception $ex) {
            $response->data = ObjResponse::CatchResponse($ex->getMessage());
        }
        return response()->json($response, $response->data["status_code"]);
    }
}

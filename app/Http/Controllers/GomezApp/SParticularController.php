<?php

namespace App\Http\Controllers\GomezApp;

use App\Http\Controllers\Controller;
use App\Models\GomezApp\SParticular;  //ESTA ES LA TABLA
use App\Models\GomezApp\SpRequests;  //ESTA ES LA VISTA
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
    public function postImgsAttach(Request $request, Response $response,$id)
    {

        try {

            $response->data = ObjResponse::DefaultResponse();
            $updateReport = SParticular::find($id);
            
            $updateReport->save();


            $response->data = ObjResponse::CorrectResponse();
            $response->data["message"] = 'peticion satisfactoria | usuario eliminado.';
            $response->data["alert_text"] = "Respuesta enviada";
            $response->data["result"] = ["se registraron las Evidencias" =>  $updateReport];
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
    public function response(Request $request, Response $response, $id)
    {
        $response->data = ObjResponse::DefaultResponse();
        try {
            $responseRequest = SParticular::find($id);

            if($responseRequest->respuesta == null){
                $responseRequest->respuesta = $request->response;
                $responseRequest->respuesta_at = now();
                $responseRequest->save();
            }
       

            $response->data = ObjResponse::CorrectResponse();
            $response->data["message"] = 'peticion satisfactoria | Respuesta almacenada.';
            $response->data["alert_text"] = "Respuesta Almacenada";
            $response->data["result"] = $request->all();
        } catch (\Exception $ex) {
            $response->data = ObjResponse::CatchResponse($ex->getMessage());
        }
        return response()->json($response, $response->data["status_code"]);
    }
    public function show(Response $response, $id,$user_role_id)
    {
        $response->data = ObjResponse::DefaultResponse();
        try {


            $list = SpRequests::where("id", $id)->first();
          
            if($user_role_id == 4 && $list->visto != 1 ){
                $vistoReport = SParticular::find($id);
                $vistoReport->visto = 1;
                $vistoReport->visto_at = now();
                $vistoReport->save();
            }
            $response->data = ObjResponse::CorrectResponse();
            $response->data["message"] = 'Peticion satisfactoria | Lista de mis reportes.';
            $response->data["result"] = $list;
        } catch (\Exception $ex) {
            $response->data = ObjResponse::CatchResponse($ex->getMessage());
        }
        return response()->json($response, $response->data["status_code"]);
    }
    public function update(Request $request, Response $response)
    {
        $response->data = ObjResponse::DefaultResponse();
        $idRequest = $request->id;
        try {
            $updateReport = SParticular::find($idRequest);
            $updateReport->nombre = $request->nombre;
            $updateReport->app = $request->app;
            $updateReport->apm = $request->apm;
            $updateReport->telefono = $request->telefono;
            $updateReport->cp = $request->cp;
            $updateReport->calle = $request->calle;
            $updateReport->num_ext = $request->num_ext;
            $updateReport->num_int = $request->num_int;
            $updateReport->colonia = $request->colonia;
            $updateReport->localidad = $request->localidad;
            $updateReport->estado = $request->estado;
            $updateReport->id_departamento_destino = $request->id_departamento_destino;
            $updateReport->id_asunto = $request->id_asunto;
            $updateReport->observaciones = $request->observaciones;
            $updateReport->localidad = $request->localidad;
            $updateReport->updated_at = now();
            $updateReport->save();


            $response->data = ObjResponse::CorrectResponse();
            $response->data["message"] = 'peticion satisfactoria | usuario Actualizado.';
            $response->data["alert_text"] = "Usuario Actualizado";
        } catch (\Exception $ex) {
            $response->data = ObjResponse::CatchResponse($ex->getMessage());
        }
        return response()->json($response, $response->data["status_code"]);
    }
    public function requestviewByIdDep(Request $request, Response $response)
    {
        $data = $request->all();
        $array = array();
        foreach ($data as $key => $value) {
            $array[] = $value['departamento_id'];
        }
        $response = SpRequests::whereIn("id_departamento_destino", $array)->get();
        return response()->json($response);
    }

    public function attachImgs(Request $request, Response $response, $id)
    {
        $response->data = ObjResponse::DefaultResponse();
        try {
                $responseRequest = SParticular::find($id);
                $img_attach_1 = $this->ImageUp($request, 'img_attach_1', $request->id, 'evidencia-1', false, "sinEvidencia.png");
                if ($request->hasFile('img_attach_1')) $responseRequest->img_attach_1 = $img_attach_1;
                $responseRequest->save();
        
       

            $response->data = ObjResponse::CorrectResponse();
            $response->data["message"] = 'peticion satisfactoria | Respuesta almacenada.';
            $response->data["alert_text"] = "Respuesta Almacenada";
            $response->data["result"] = $request->all();
        } catch (\Exception $ex) {
            $response->data = ObjResponse::CatchResponse($ex->getMessage());
        }
        return response()->json($response, $response->data["status_code"]);
    }


    private function imageUp($request, $requestFile, $id, $posFix, $create, $nameFake)
    {
        $dir_path = "ATC/sp-solicitudes";
        $dir = public_path($dir_path);
        $img_name = "";
        if ($request->hasFile($requestFile)) {
            $img_file = $request->file($requestFile);
            $instance = new Controller();
            $dir_path = "$dir_path/$id";
            $dir = "$dir/$id";
            $img_name = $instance->imgUpload($img_file, $dir, $dir_path, "$id-$posFix");
        } else {
            if ($create) $img_name = "$dir_path/$nameFake";
        }
        return $img_name;
    }
}

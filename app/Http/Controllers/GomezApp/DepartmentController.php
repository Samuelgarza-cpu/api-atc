<?php

namespace App\Http\Controllers\GomezApp;

use App\Http\Controllers\Controller;
use App\Models\GomezApp\Department;
use App\Models\ObjResponse;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\DB;

class DepartmentController extends Controller
{
    /**
     * Mostrar lista de departamentos activas.
     *
     * @return \Illuminate\Http\Response $response
     */
    public function index(Response $response)
    {
        $response->data = ObjResponse::DefaultResponse();
        try {
            $list = Department::where('active', true)
                ->select('departments.*')
                ->orderBy('departments.id', 'asc')->get();
            $response->data = ObjResponse::CorrectResponse();
            $response->data["message"] = 'Peticion satisfactoria | Lista de departamentos.';
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
            $list = Department::where('active', true)
                ->select('departments.id as value', 'departments.department as text')
                ->orderBy('departments.department', 'asc')->get();
            $response->data = ObjResponse::CorrectResponse();
            $response->data["message"] = 'Peticion satisfactoria | Lista de departamentos';
            $response->data["result"] = $list;
        } catch (\Exception $ex) {
            $response->data = ObjResponse::CatchResponse($ex->getMessage());
        }
        return response()->json($response, $response->data["status_code"]);
    }

    /**
     * Crear un nuevo departamento.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response $response
     */
    public function create(Request $request, Response $response)
    {
        $response->data = ObjResponse::DefaultResponse();
        try {
            $new_department = Department::create([
                'department' => $request->department,
                'director' => $request->director,
                'description' => $request->description,
            ]);
            $response->data = ObjResponse::CorrectResponse();
            $response->data["message"] = 'peticion satisfactoria | departamento registrado.';
            $response->data["alert_text"] = 'Departamento registrado';
            $response->data["RESULT"] = $request->all();
        } catch (\Exception $ex) {
            $response->data = ObjResponse::CatchResponse($ex->getMessage());
        }
        return response()->json($response, $response->data["status_code"]);
    }

    /**
     * Mostrar departamento.
     *
     * @param   int $id
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response $response
     */
    public function show(Request $request, Response $response)
    {
        $response->data = ObjResponse::DefaultResponse();
        try {
            $department = Department::find($request->id);

            $response->data = ObjResponse::CorrectResponse();
            $response->data["message"] = 'peticion satisfactoria | departamento encontrado.';
            $response->data["result"] = $department;
        } catch (\Exception $ex) {
            $response->data = ObjResponse::CatchResponse($ex->getMessage());
        }
        return response()->json($response, $response->data["status_code"]);
    }

    /**
     * Actualizar departamento.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response $response
     */
    public function update(Request $request, Response $response)
    {
        $response->data = ObjResponse::DefaultResponse();
        try {
            $department = Department::find($request->id)
                ->update([
                    'department' => $request->department,
                    'director' => $request->director,
                    'description' => $request->description,
                ]);

            $response->data = ObjResponse::CorrectResponse();
            $response->data["message"] = 'peticion satisfactoria | departamento actualizado.';
            $response->data["alert_text"] = 'Departamento actualizado';
        } catch (\Exception $ex) {
            $response->data = ObjResponse::CatchResponse($ex->getMessage());
        }
        return response()->json($response, $response->data["status_code"]);
    }

    /**
     * Eliminar (cambiar estado activo=false) departamento.
     *
     * @param  int $id
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response $response
     */
    public function destroy(Request $request, Response $response)
    {
        $response->data = ObjResponse::DefaultResponse();
        try {
            Department::find($request->id)
                ->update([
                    'active' => false,
                    'deleted_at' => date('Y-m-d H:i:s'),
                ]);
            $response->data = ObjResponse::CorrectResponse();
            $response->data["message"] = 'peticion satisfactoria | departamento eliminado.';
            $response->data["alert_text"] = 'Departamento eliminado';
        } catch (\Exception $ex) {
            $response->data = ObjResponse::CatchResponse($ex->getMessage());
        }
        return response()->json($response, $response->data["status_code"]);
    }
}
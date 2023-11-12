<?php

namespace App\Http\Controllers\GomezApp;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\GomezApp\AsuntosDep;
use App\Models\GomezApp\AsuntosDepTable;
use App\Models\ObjResponse;
use Illuminate\Http\Response;

class AsuntosDepController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Response $response)
    {
        $response->data = ObjResponse::DefaultResponse();
        try {
            $list = AsuntosDep::all();
            $response->data = ObjResponse::CorrectResponse();
            $response->data["message"] = 'Peticion satisfactoria | Lista de departamentos.';
            $response->data["result"] = $list;
        } catch (\Exception $ex) {
            $response->data = ObjResponse::CatchResponse($ex->getMessage());
        }
        return response()->json($response, $response->data["status_code"]);
    }

    public function vistaDepAsuntos(Response $response)
    {
        $response->data = ObjResponse::DefaultResponse();
        try {
            $list = AsuntosDep::all();
            $response->data = ObjResponse::CorrectResponse();
            $response->data["message"] = 'Peticion satisfactoria | Lista de departamentos.';
            $response->data["result"] = $list;
        } catch (\Exception $ex) {
            $response->data = ObjResponse::CatchResponse($ex->getMessage());
        }
        return response()->json($response, $response->data["status_code"]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, Response $response)
    {

        try {
            $request->validate([
                'depart' => 'required',
                'asunto' => 'required'
            ]);

            $DepAsu = new AsuntosDepTable;
            $DepAsu->department_id = $request->depart;
            $DepAsu->asunto_id = $request->asunto;
            $DepAsu->save();

            $response->data = ObjResponse::CorrectResponse();
            $response->data["message"] = 'peticion satisfactoria';
            $response->data["alert_text"] = 'Se Guardo Correctamente';
            $response->data["result"] = $DepAsu;

            return response()->json($response, $response->data["status_code"]);
        } catch (\Exception $error) {
            return $error->getMessage();
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Response $response, $id)
    {
        $response->data = ObjResponse::DefaultResponse();
        try {
            $list = AsuntosDep::where('department_id', $id)->get();
            return $list;
            $response->data = ObjResponse::CorrectResponse();
            $response->data["message"] = 'Peticion satisfactoria | Lista de departamentos.';
            $response->data["result"] = $list;
        } catch (\Exception $ex) {
            $response->data = ObjResponse::CatchResponse($ex->getMessage());
        }
        return response()->json($response, $response->data["status_code"]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, Response $response)
    {


        try {

            $response->data = ObjResponse::DefaultResponse();

            $destroy = AsuntosDepTable::where('department_id', $request->department_id)
                ->where("asunto_id", $request->asuntos_id)->delete();


            // $destroy->delete();
            $response->data = ObjResponse::CorrectResponse();
            $response->data["message"] = 'Peticion satisfactoria';
            $response->data["result"] = $destroy;
            return response()->json($response, $response->data["status_code"]);
        } catch (\Exception $ex) {
            $response->data = ObjResponse::CatchResponse($ex->getMessage());
        }
        return response()->json($response, $response->data["status_code"]);
    }
}

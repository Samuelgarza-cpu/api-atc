<?php

namespace App\Http\Controllers\GomezApp;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class AtcAppController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return "ENTRA POR FAVOR";
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

        $latitud = "";
        $longitud = "";
        $lat = $request->latitud == "" ? "" : $request->latitud;
        $long = $request->longitud == "" ? "" : $request->longitud;
        $url = "";
        $pattern = "/[^0-9.-]/";
        if ($request->url != "") {
            $url = explode("@", $request->url);
            if ($url[0] == $request->url) {
                $url = "";
            } else {
                $url2 = explode(",", $url[1]);
                $lat = $url2[0];
                $long = $url2[1];
            }
        }

        $longitud_cadena = 5;
        $caracteres_alfabeticos = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $caracter_alfabetico = $caracteres_alfabeticos[mt_rand(0, strlen($caracteres_alfabeticos) - 1)];
        $numeros = mt_rand(pow(10, $longitud_cadena - 2), pow(10, $longitud_cadena - 1) - 1);
        $cadena_aleatoria = $caracter_alfabetico . $numeros;

        $response->data = ObjResponse::DefaultResponse();
        $result = [];
        try {
            $imgName = "";
            if ($request->hasFile('imgFile')) {
                $image = $request->file('imgFile');
                $imgName = time() . '.' . $image->getClientOriginalExtension();
                $image->move(public_path('GomezApp/reportes'), $imgName);
            }


            $reports = new Report;
            $reports->fecha_reporte = $request->fecha_reporte;
            $reports->img_reporte = "GomezApp/reportes/$imgName";
            $reports->folio = $request->folio;
            $reports->latitud = $request->latitud;
            $reports->longitud = $request->longitud;
            $reports->id_user = $request->id_user;
            $reports->id_departamento = $request->id_departamento;
            $reports->id_estatus = 1;
            $reports->id_origen = 3;
            $reports->referencias = $request->referencias;
            $reports->created_at = now();
            $reports->save();


            $reportsAsunt2 = new ReportAsuntos();
            $reportsAsunt2->id_reporte = $reports->id;
            $reportsAsunt2->id_servicio = 1;
            $reportsAsunt2->id_asunto = $request->id_asunto;
            $reportsAsunt2->observaciones = $request->comentario;
            $reportsAsunt2->save();

            $response->data = ObjResponse::CorrectResponse();
            $response->data["message"] = 'Peticion satisfactoria | Lista de mis reportes.';
        } catch (\Exception $ex) {
            $response->data = ObjResponse::CatchResponse($ex->getMessage());
        }
        return response()->json($response, $response->data["status_code"]);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
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
    public function destroy($id)
    {
        //
    }
}

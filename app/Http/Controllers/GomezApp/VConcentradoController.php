<?php

namespace App\Http\Controllers\GomezApp;

use App\Http\Controllers\Controller;
use App\Models\GomezApp\ConcentradoViewAtc;
use Illuminate\Http\Request;

class VConcentradoController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data = ConcentradoViewAtc::all();
        return response()->json($data);
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
    public function store(Request $request)
    {
        try {
            $consulta = ConcentradoViewAtc::query();

            if ($request->filled('nameDepartamento')) {
                $consulta->where('department', $request->nameDepartamento);
            }

            if ($request->filled('nameAsunto')) {
                $consulta->where('asunto', $request->nameAsunto);
            }

            if ($request->filled('dateInicial') && $request->filled('dateFinal')) {
                $consulta->whereBetween('fecha_reporte', [$request->dateInicial, $request->dateFinal]);
            } elseif ($request->filled('dateInicial')) {
                $consulta->where('fecha_reporte', $request->dateInicial);
            }

            $resultados = $consulta->get();
            $ResultadoAgrupado = [];
            foreach ($resultados as $registro) {
                $key = $registro->department;

                if (!isset($ResultadoAgrupado[$key])) {
                    $ResultadoAgrupado[$key] = [
                        'department' => $registro->department,
                        'asunto' => $registro->asunto,
                        'PETICIONES' => $registro->PETICIONES,
                        'TERMINADO' => $registro->TERMINADO,
                        'NO_PROCEDE' => $registro->NO_PROCEDE,
                        'EN_TRAMITE' => $registro->EN_TRAMITE,
                        'TOTAL' => $registro->TOTAL,
                        'PENDIENTES' => $registro->PENDIENTES,

                    ];
                } else {
       
                    $ResultadoAgrupado[$key]['PETICIONES'] += $registro->PETICIONES;
                    $ResultadoAgrupado[$key]['TERMINADO'] += $registro->TERMINADO;
                    $ResultadoAgrupado[$key]['NO_PROCEDE'] += $registro->NO_PROCEDE;
                    $ResultadoAgrupado[$key]['EN_TRAMITE'] += $registro->EN_TRAMITE;
                    $ResultadoAgrupado[$key]['TOTAL'] += $registro->TOTAL;
                    $ResultadoAgrupado[$key]['PENDIENTES'] += $registro->PENDIENTES;
                }
            }

            return $ResultadoAgrupado;

            // Convertimos el array asociativo en un array de objetos
            // $ResultadoAgrupado = array_values($ResultadoAgrupado);

            return response()->json([
                'success' => true,
                'data' => $ResultadoAgrupado
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error al procesar la solicitud',
                'error' => $e->getMessage()
            ], 500);
        }
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

<?php

namespace App\Http\Controllers;

use App\Models\Despesa;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function __construct(
        private Despesa $despesa
    )
    {}

    public function index(Request $request)
    {
        $quantidadeMesesAnterior = 5;
        $data = $this->despesa->getDespesasPorAnoMes($request->user_id, $quantidadeMesesAnterior);

        $response = [
            'dados' => $data,
            'quantidade_meses' => $quantidadeMesesAnterior,
            'total' => $totalDespesas = $data->sum('total_despesas')
        ];

        return response()->json(data: $response, status:200);
    }
}

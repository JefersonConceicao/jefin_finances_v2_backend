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
        $response = $this->despesa->getDespesasPorAnoMes($request->user_id);
        return response()->json($response, 200);
    }
}

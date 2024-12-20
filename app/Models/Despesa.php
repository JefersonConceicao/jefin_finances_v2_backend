<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Despesa extends Model
{
    use HasFactory;
    protected $table = 'despesas';

    public function getDespesasPorAnoMes(int $user_id, $quantidadeMesesAnterior = 5): Collection
    {
        $anoAtual = date('Y');

        return $this
            ->select(
                DB::raw('YEAR(created_at) ano'),
                DB::raw('MONTH(created_at) mes'),
                DB::raw(value: 'SUM(valor_total) total_despesas')
            )
            ->where([
                ['user_id', '=', $user_id],
                [DB::raw('YEAR(created_at)'), '<=', $anoAtual]
            ])
            ->groupBy(
                DB::raw('YEAR(created_at)'),
                DB::raw('MONTH(created_at)'),
            )
            ->limit($quantidadeMesesAnterior)
            ->orderBy(DB::raw('YEAR(created_at)'), 'DESC')
            ->orderBy(DB::raw('MONTH(created_at)'), 'DESC')
            ->get();
    }
}

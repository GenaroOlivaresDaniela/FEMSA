<?php

namespace App\Traits\Models;

use Illuminate\Database\Eloquent\Builder;

/**
 * WithCustomScopes
 *
 * @package App\Models
 * @author Daniela
 */
trait WithCustomScopes
{
    /**
     * Filtro where no obligatorio
     *
     * @param Builder $builder
     * @param string $columna
     * @param string $operador
     * @param string|integer|null $busqueda
     * @return Builder|void
     */
    public function scopeWhereNotRequired(Builder $builder, string $columna, string $operador, $busqueda = null)
    {
        if ($busqueda !== null) return $builder->where($columna, $operador, $busqueda);
    }
}

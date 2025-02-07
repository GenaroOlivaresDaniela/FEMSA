<?php

use App\Helpers\ResponseHelper;

/**
 * Request
 *
 * @package App\PolyFills
 * @author Daniela
 */

/**
 * Verifica que no exista la funcion global getRequestId_ y si es asi la crea
 */
if (!function_exists('getRequestId_')) {
    /**
     * Obtiene el request id
     *
     * @return string
     */
    function getRequestId_(): string
    {
        return ResponseHelper::getRequestId();
    }
}

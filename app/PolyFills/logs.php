<?php

use Illuminate\Support\Facades\Log;

/**
 * Logs
 *
 * @package App\PolyFills
 * @author Daniela
 */


/**
 * Verifica que no exista la funcion global info_ y si es asi la crea
 */
if (!function_exists('info_')) {
    /**
     * Genera un log de tipo info
     *
     * @param string $message
     * @param array $context
     * @return void
     */
    function info_(string $message = '', array $context = []): void
    {
        $context = array_merge($context, ['request-id' => getRequestId_()]);
        Log::info($message, $context);
    }
}

/**
 * Verifica que no exista la funcion global debug_ y si es asi la crea
 */
if (!function_exists('debug_')) {
    /**
     * Genera un log de tipo debug
     *
     * @param string $message
     * @param array $context
     * @return void
     */
    function debug_(string $message = '', array $context = []): void
    {
        $context = array_merge($context, ['request-id' => getRequestId_()]);
        Log::debug($message, $context);
    }
}

/**
 * Verifica que no exista la funcion global error_ y si es asi la crea
 */
if (!function_exists('error_')) {
    /**
     * Genera un log de tipo error
     *
     * @param string $message
     * @param array $context
     * @return void
     */
    function error_(string $message = '', array $context = []): void
    {
        $context = array_merge($context, ['request-id' => getRequestId_()]);
        Log::error($message, $context);
    }
}

/**
 * Verifica que no exista la funcion global alert_ y si es asi la crea
 */
if (!function_exists('alert_')) {
    /**
     * Genera un log de tipo alert
     *
     * @param string $message
     * @param array $context
     * @return void
     */
    function alert_(string $message = '', array $context = []): void
    {
        $context = array_merge($context, ['request-id' => getRequestId_()]);
        Log::alert($message, $context);
    }
}

/**
 * Verifica que no exista la funcion global critical_ y si es asi la crea
 */
if (!function_exists('critical_')) {
    /**
     * Genera un log de tipo critical
     *
     * @param string $message
     * @param array $context
     * @return void
     */
    function critical_(string $message = '', array $context = []): void
    {
        $context = array_merge($context, ['request-id' => getRequestId_()]);
        Log::critical($message, $context);
    }
}

/**
 * Verifica que no exista la funcion global emergency_ y si es asi la crea
 */
if (!function_exists('emergency_')) {
    /**
     * Genera un log de tipo emergency
     *
     * @param string $message
     * @param array $context
     * @return void
     */
    function emergency_(string $message = '', array $context = []): void
    {
        $context = array_merge($context, ['request-id' => getRequestId_()]);
        Log::emergency($message, $context);
    }
}

/**
 * Verifica que no exista la funcion global notice_ y si es asi la crea
 */
if (!function_exists('notice_')) {
    /**
     * Genera un log de tipo notice
     *
     * @param string $message
     * @param array $context
     * @return void
     */
    function notice_(string $message = '', array $context = []): void
    {
        $context = array_merge($context, ['request-id' => getRequestId_()]);
        Log::notice($message, $context);
    }
}

/**
 * Verifica que no exista la funcion global warning_ y si es asi la crea
 */
if (!function_exists('warning_')) {
    /**
     * Genera un log de tipo warning
     *
     * @param string $message
     * @param array $context
     * @return void
     */
    function warning_(string $message = '', array $context = []): void
    {
        $context = array_merge($context, ['request-id' => getRequestId_()]);
        Log::warning($message, $context);
    }
}

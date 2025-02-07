<?php

namespace App\Traits\Enums;

use Illuminate\Support\Str;

/**
 * Trait ConstantsAccess
 *
 * @author Daniela
 */
trait ConstantsAccess
{
    /**
     * Lanza una excepción
     *
     * @param string $mensaje
     * @param bool $throwException
     * @return void
     */
    private function throwException(string $mensaje, bool $throwException): void
    {
        if ($throwException) {
            $class = __CLASS__;
            abort(500, "Error en {$class}: {$mensaje}");
        }
    }

    /**
     * Obtiene todas las constantes
     *
     * @param bool $throwException
     * @return array<mixed...|empty>
     */
    public static function getAllConstants(bool $throwException)
    {
        $refClass = new \ReflectionClass(__CLASS__);
        $allConstants = $refClass->getConstants();

        if (empty($allConstants)) {
            return (new Self)->throwException(
                'No se encontraron constantes',
                $throwException
            );
        }

        return $allConstants;
    }

    /**
     * Obtiene una colección de todas las constantes
     *
     * @param bool $throwException
     * @return \Illuminate\Support\Collection<object...|empty>
     */
    public static function getAllConstantsCollection(bool $throwException)
    {
        $allConstants = self::getAllConstants($throwException);
        $return = [];

        foreach ($allConstants as $itemKey => $itemValue) {
            $return[] = (object) [
                'name'  => $itemKey,
                'value' => $itemValue
            ];
        }

        return collect($return);
    }

    /**
     * Obtiene una constante por el nombre
     *
     * @param string $constantValue
     * @param bool $throwException Si es false y no se encuentra la constante, se retorna null
     * @return mixed|null
     */
    public static function getConstantValueByName(string $constantName, bool $throwException = true)
    {
        $self = new self();

        $allConstantsCollection = $self->getAllConstantsCollection($throwException);
        $searchConstant = $allConstantsCollection->where('name', '=', $constantName)->first();

        if (!$searchConstant) {
            return $self->throwException(
                "No se encontró ninguna constante con nombre '{$constantName}'",
                $throwException
            );
        }

        return $searchConstant->value ?? null;
    }

    /**
     * Obtiene el nombre de una constante por su valor
     *
     * @param mixed $constantValue
     * @param bool $throwException Si es false y no se encuentra la constante, se retorna null
     * @return string|null
     */
    public static function getConstantNameByValue($constantValue, bool $throwException = true)
    {
        $self = new self();

        $allConstantsCollection = $self->getAllConstantsCollection($throwException);
        $searchConstant = $allConstantsCollection->where('value', '=', $constantValue)->first();

        if (!$searchConstant) {
            return $self->throwException(
                "No se encontró ninguna constante con valor '{$constantValue}'",
                $throwException
            );
        }

        $constantName = (isset($searchConstant->name)) ? Str::replace('_', ' ', $searchConstant->name) : null;
        return $constantName;
    }

    /**
     * Obtiene los nombres de las constantes que coincidan con el mismo valor
     *
     * @param mixed $constantsValue
     * @param bool $throwException Si es false y no se encuentran las constantes, se retorna una colección vacía
     * @return \Illuminate\Support\Collection<string...|empty>
     */
    public static function getAllConstantsNamesByValue($constantsValue, bool $throwException = true)
    {
        $self = new self();

        $allConstantsCollection = $self->getAllConstantsCollection($throwException);
        $searchConstants = $allConstantsCollection
            ->where('value', '=', $constantsValue)
            ->map(function ($item) {
                return Str::replace('_', ' ', $item->name);
            });

        if ($searchConstants->isEmpty()) {
            return $self->throwException(
                "No se encontraron constantes con valor '{$constantsValue}'",
                $throwException
            );
        }

        return $searchConstants;
    }
}

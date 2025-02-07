<?php

namespace App\Helpers;

use App\Enums\HttpStatusEnum;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;

/**
 * ValidatorHelper
 *
 * @package App\Helpers
 * @author Daniela
 */
class ValidatorHelper
{
    /**
     * Make validation for service
     *
     * Obtiene los datos requeridos para la validación directamente de la clase request indicada,
     * [NO es compatible con los métodos prepareForValidation ni passedValidation]
     *
     * @param string $classNameRequest
     * @param array $data
     * @param bool $returnValidated
     * @return array
     * @throws \HttpException
     * @author Daniela
     */
    public static function make(string $classNameRequest, array $data, bool $returnValidated = true)
    {
        class_exists($classNameRequest) or abort(HttpStatusEnum::INTERNAL_SERVER_ERROR, "Class '{$classNameRequest}' not found.");

        $classRequest               = new $classNameRequest;
        $authorizeMethod            = method_exists($classRequest, 'authorize')  ? $classRequest->authorize()  : true;
        $rulesMethod                = method_exists($classRequest, 'rules')      ? $classRequest->rules()      : [];
        $messagesMethod             = method_exists($classRequest, 'messages')   ? $classRequest->messages()   : [];
        $customAttributesMethod     = method_exists($classRequest, 'attributes') ? $classRequest->attributes() : [];

        if (!$authorizeMethod) abort(HttpStatusEnum::UNAUTHORIZED, 'Unauthorized.');

        $validator = Validator::make($data, $rulesMethod, $messagesMethod, $customAttributesMethod);
        if ($validator->fails()) throw new ValidationException($validator);

        if ($returnValidated) $data = $validator->validated();
        return $data;
    }
}

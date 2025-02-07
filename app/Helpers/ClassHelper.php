<?php

namespace App\Helpers;

/**
 * ClassHelper
 *
 * @package App\Helpers
 * @author Daniela
 */
class ClassHelper
{
    /**
     * Construct.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Get the class "basename" of the given object / class.
     *
     * @param string|object  $class
     * @return string
     */
    public static function getName($class)
    {
        $class = is_object($class) ? get_class($class) : $class;
        $class = str_replace('\\', '/', $class);

        return basename($class);
    }
}

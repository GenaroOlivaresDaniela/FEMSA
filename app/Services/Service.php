<?php

namespace App\Services;

use App\Helpers\ClassHelper;
use App\Helpers\ValidatorHelper;
use Illuminate\Support\Facades\DB;


class Service
{
    /**
     * Self transaction
     *
     * @var bool
     */
    private $selfTransaction = false;

    /**
     * Get the name of the class
     *
     * @return string
     */
    protected function getClassName(int $indexClassPosition = 1)
    {
        $class = 'unknownClass';
        if (!empty(debug_backtrace())) {
            if (!empty(debug_backtrace()[$indexClassPosition])) {
                if (!empty(debug_backtrace()[$indexClassPosition]['class'])) {
                    $class = ClassHelper::getName(debug_backtrace()[$indexClassPosition]['class']);
                }
            }
        }

        return $class;
    }

    /**
     * Get the name of the method
     *
     * @return string
     */
    protected function getMethodName(int $indexMethodPosition = 1)
    {
        $function = 'unknownMethod';
        if (!empty(debug_backtrace())) {
            if (!empty(debug_backtrace()[$indexMethodPosition])) {
                if (!empty(debug_backtrace()[$indexMethodPosition]['function'])) {
                    $function = debug_backtrace()[$indexMethodPosition]['function'];
                }
            }
        }
        return $function;
    }

    /**
     * Get the arguments used in the method
     *
     * @return array|null
     */
    protected function getMethodArgs(int $indexMethodPosition = 1)
    {
        $args = null;
        if (!empty(debug_backtrace())) {
            if (!empty(debug_backtrace()[$indexMethodPosition])) {
                if (!empty(debug_backtrace()[$indexMethodPosition]['args'])) {
                    $args = (array) debug_backtrace()[$indexMethodPosition]['args'];
                }
            }
        }

        return $args;
    }

    /**
     * Get the class name and method name
     *
     * @return string
     */
    protected function getClassNameAndMethod(int $indexClassAndMethodPosition = 2)
    {
        return $this->getClassName($indexClassAndMethodPosition) . '::' . $this->getMethodName($indexClassAndMethodPosition) . '()';
    }

    /**
     * Make a debug log for init method
     *
     * @return void
     */
    protected function logInitMethod()
    {
        debug_(
            "Inicia {$this->getClassNameAndMethod(3)}",
            [
                'arguments' => $this->getMethodArgs(2),
            ]
        );
    }

    /**
     * Make a debug log for end method
     *
     * @return void
     */
    protected function logEndMethod()
    {
        debug_("Finaliza {$this->getClassNameAndMethod(3)}");
    }

    /**
     * Validate for service
     *
     * @param string $rulesRequest
     * @param array $data
     * @param bool $validateData
     * @param bool $applyValidatedToData
     * @return void
     */
    protected function validate(string $rulesRequest, array &$data, bool $validateData = true, bool $applyValidatedToData = true)
    {
        $this->logInitMethod();

        if ($validateData) $data = ValidatorHelper::make($rulesRequest, $data, $applyValidatedToData);
        debug_('Datos de entrada', $data);

        $this->logEndMethod();
    }

    /**
     * DB Begin Transaction
     *
     * @param bool $transactionExists
     * @return void
     */
    protected function dbBeginTransaction(bool &$transactionExists)
    {
        $this->logInitMethod();

        if (!$transactionExists) {
            debug_("Se crea la transacción");
            DB::beginTransaction();
            $transactionExists = true;
            $this->selfTransaction = true;
        }

        $this->logEndMethod();
    }

    /**
     * DB Commit
     *
     * @param bool $transactionExists
     * @return void
     */
    protected function dbCommit(bool $transactionExists)
    {
        $this->logInitMethod();

        if ($transactionExists == false or $this->selfTransaction == true) {
            debug_("Se realiza el commit");
            DB::commit();
        }

        $this->logEndMethod();
    }

    /**
     * DB Rollback
     *
     * @param string $messageRollback
     * @param bool $transactionExists
     * @return void
     */
    protected function dbRollback(string $messageRollback, bool $transactionExists)
    {
        $this->logInitMethod();

        if ($transactionExists == false or $this->selfTransaction == true) {
            debug_("Se hace ROLLBACK: {$messageRollback}");
            DB::rollBack();
        }

        $this->logEndMethod();
    }
}

<?php

/**
 * Copyright 2018 Magento. All rights reserved.
 */

namespace Rce\Calculator\Model;

use Rce\Calculator\Api\CalculatorInterface;
use Rce\Calculator\Api\Data\ResultInterface;
use Rce\Calculator\Api\Data\ResultInterfaceFactory;
use Rce\Calculator\Api\Data\Result;


/**
 * Defines the implementation class of the calculator service contract.
 */
class Calculator implements CalculatorInterface
{

    /**
     * @var $resultFactory
     * list of allowed operations
     */
    private $allowedOperations = array('add','subtract','multiply','divide','power');

    /**
     * @var $resultFactory
     * Factory for creating new result instances. This code will be automatically
     * generated because the type ends in "Factory".
     */
    private $resultFactory;

    public function __construct(
        ResultInterfaceFactory $resultFactory
    ) {
        $this->resultFactory = $resultFactory;
    }

    /**
     * Return result of calculation.
     *
     * @param float $left Left hand operand.
     * @param float $right Right hand operand.
     * @param string $operator operator identification.
     * @param int $precision precision of result.
     * @return Rce\Calculator\Api\Data\ResultInterface $r
     */
    public function calculator($left, $right, $operator, $precision = 2) {
        $r = $this->resultFactory->create();

        if (!$this->validate($left, $right, $operator)) {
            $r->setStatus('Validation error.');
            return $r;
        }

        $result = null;
        switch ($operator) {
            case 'add':
                $result = $left + $right;
                break;
            case 'subtract':
                $result = $left - $right;
                break;
            case 'multiply':
                $result = $left * $right;
                break;
            case 'divide':
                if ($right == 0) {
                    $r->setStatus("Zero division error");
                    return $r;
                }
                $result = $left / $right;
                break;
            case 'power':
                $result = pow($left,$right);
                break;
            default:
                $r->setStatus('Error. Operation not found');
                return $r;
        }
        $r->setStatus('Ok.');
        $r->setResult(number_format($result, $precision));
        return $r;
    }

    /**
     * Validates passed API parameters
     *
     * @param float $left Left hand operand.
     * @param float $right Right hand operand.
     * @param string $operator operator identification.
     * @return bool
     */
    public function validate($left, $right, $operator) {
        if (!is_numeric($left) || !is_numeric($right) || !in_array($operator, $this->allowedOperations)) {
            return false;
        } else {
            return true;
        }
    }
}

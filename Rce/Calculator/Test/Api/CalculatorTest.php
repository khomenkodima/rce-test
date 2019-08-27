<?php

/**
 * Copyright 2015 Magento. All rights reserved.
 */

namespace Rce\Calculator\Test\Api;

use Magento\Framework\Webapi\Rest\Request;
use Magento\InventoryApi\Api\Data\StockInterface;
use Magento\TestFramework\Assert\AssertArrayContains;
use Magento\TestFramework\TestCase\WebapiAbstract;


/**
 * Defines the implementation class of the calculator service contract.
 */
class CalculatorTest extends WebapiAbstract
{

    public function testCalculate()
    {
        $serviceInfo = [
            'rest' => [
                'resourcePath' => '/V1/rce/calculator',
                'httpMethod' => \Magento\Framework\Webapi\Rest\Request::HTTP_METHOD_POST,
            ],
        ];

        $requestDataAdd = [
            'left' => 1.42,
            'right' => 2.4567,
            'operator' => 'add',
            'precision' => 2
        ];

        $requestDataValidation = [
            'left' => 1.42,
            'right' => 2.4567,
            'operator' => 'none',
        ];

        $responseAdd = $this->_webApiCall($serviceInfo, $requestDataAdd);
        $responseDataValidation = $this->_webApiCall($serviceInfo, $requestDataValidation);

        $this->assertEquals('Ok.', $responseAdd['status']);
        $this->assertEquals(3.88, $responseAdd['result']);
        $this->assertEquals('Validation error.', $responseDataValidation['status']);
        $this->assertEquals(null, $responseDataValidation['result']);
    }

}
RCE Calculator

Extension implements basic math operations calculation via Magento 2 Rest API.

Installation:
1. Copy source code to Magento directory app/code.
2. Register the extension
   bin/magento setup:upgrade
3. Recompile your Magento project:
   bin/magento setup:di:compile
4. Flush cache
   php bin/magento cache:flush
5. Verify that the extension is enabled:
   bin/magento module:status Rce_Calculator

Usage:

API expects POST request to endpoint V1/rce/calculator, parameters should be passed as JSON object:

{

    "left": left operand,

    "right": right operand,

    "operator": operator,

    "precision": precision
}

- left and right operands are float values.
- operator is string with allowed values: add, subtract, multiply, divide, power
- precision is optional, and default is 2

Response is JSON object:

{

    "status": status,

    "value": value
}

 - status is "Ok" or Error message.
 - value contains result of calculation or null in case of error

Example of usage:

curl -d '{"left":1.43, "right": 2.4567, "operator": "add", "precision": 2}' -H 'Content-Type: application/json' http://server.url/index.php/rest/V1/rce/calculator


Unit test:

If environment is configured as explained here: http://devdocs.magento.com/guides/v2.0/get-started/web-api-functional-testing.html
Test could be started with command:

 phpunit -c dev/tests/api-functional/phpunit.xml --filter testCalculate
<?php
/**
 * Submit a newsletter registration request to Emarsys
 *
 * User: Mark Howard
 * Date: 25/02/18
 * Time: 12:27 PM
 */

$result = false;

// read JSON
try {

    // read the input JSON, if any
    $rawRequestJson = file_get_contents("php://input");
    if (trim($rawRequestJson) != '') {

        $requestJson = json_decode($rawRequestJson, true);

        if ($requestJson === null) { // failed to deserialize
            $result = false;
        } else {
            // handle sign up

            $emarsysClient = new EmarsysClient();
            // sort out any undefined variables
            $variableChecks = array(
                'email', 'country', 'opt_in', 'first_name', 'last_name',
                'signup_4otf'
            );
            foreach ($variableChecks as $check) {
                if (!isset($requestJson[$check])) {
                    $requestJson[$check] = null;
                }
            }

            $emarsysClient->minimalSubscribe(
                $requestJson['email'],
                $requestJson['country'],
                $requestJson['opt_in'],
                $requestJson['first_name'],
                $requestJson['last_name'],
                $requestJson['signup_4otf']
            );

            $result = true;
        }
    }

} catch (Exception $e) {
    eZLog::write( 'Unexpected error, the message was : ' .
        $e->getMessage(), 'error.log');
    $result = false;
}

print(json_encode($result));
eZExecution::cleanExit();

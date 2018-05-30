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

            $emarsysClient->minimalSubscribe(
                $requestJson['email'],
                $requestJson['country'],
                $requestJson['opt_in'],
                $requestJson['first_name'],
                $requestJson['last_name']
            );

            $result = true;
        }
    }

} catch (Exception $e) {
    $result = false;
}

print(json_encode($result));
eZExecution::cleanExit();

<?php

$module = $Params['Module'];
$errors = array();

$http = eZHTTPTool::instance();
$email = $http->variable('email');

if( $email ) {

    try {
        $emarsysClient = new EmarsysClient();

        // gather the post variables as fields to map through to Emarsys. The client will filter out those it doesn't recognize.
        $fields = $_POST;
        $emarsysClient->addOrUpdateContactArbitraryFields($fields);

    } catch (Exception $err) {}
}

eZExecution::cleanExit();
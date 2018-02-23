#!/usr/bin/env php
<?php

require 'autoload.php';

$cli = eZCLI::instance();
$cli->setUseStyles( true );

$scriptSettings = array();
$scriptSettings['description']    = 'Finds an Emarsys contact by email address.';
$scriptSettings['use-session']    = false;
$scriptSettings['use-modules']    = true;
$scriptSettings['use-extensions'] = true;

$script  = eZScript::instance( $scriptSettings );
$script->startup();
$options = $script->getOptions();
$script->initialize();

$arguments = $options['arguments'];

if (count($arguments) == 0) {
    $cli->error("Supply an email address on the command line.");

    $script->shutdown(2);
}

$apiClient = new EmarsysClient();

foreach ($arguments as $emailAddress) {
    try {
        $result = $apiClient->findFirstContact($emailAddress);

        if ($result) {
            $cli->output("OK: " . json_encode($result));
        } else {
            $cli->output("Not found");
        }
    } catch (EmarsysApiException $e) {
        $cli->error("API Error (HTTP " . $e->getCode() .  "): " . $e->getMessage());
    } catch (EmarsysCommsException $e) {
        $cli->error("Communication Error: " . $e->getMessage());
    }

}


$cli->output( 'Done.');

$script->shutdown( 0 );
?>
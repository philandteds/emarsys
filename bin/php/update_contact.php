#!/usr/bin/env php
<?php

require 'autoload.php';

$cli = eZCLI::instance();
$cli->setUseStyles( true );

$scriptSettings = array();
$scriptSettings['description']    = 'Adds/updates an eZ User as an Emarsys contact.';
$scriptSettings['use-session']    = false;
$scriptSettings['use-modules']    = true;
$scriptSettings['use-extensions'] = true;

$script  = eZScript::instance( $scriptSettings );
$script->startup();
$options = $script->getOptions( $config = '', $argumentConfig = '', $optionHelp = false,
    $arguments = false, $useStandardOptions = array('user' => true) );
$script->initialize();

$arguments = $options['arguments'];

if (count($arguments) == 0) {
    $cli->error("Supply a userID on the command line.");

    $script->shutdown(2);
}

$apiClient = new EmarsysClient();

foreach ($arguments as $userId) {
    try {
        $result = $apiClient->addOrUpdateContact($userId);

        $cli->output("OK: " . json_encode($result));
    } catch (EmarsysApiException $e) {
        $cli->error("API Error (HTTP " . $e->getCode() .  "): " . $e->getMessage());
    } catch (EmarsysCommsException $e) {
        $cli->error("Communication Error: " . $e->getMessage());
    }

}


$cli->output( 'Done.');

$script->shutdown( 0 );
?>
<?php

$Module = array( 'name' => 'Emarsys Interface' );

$ViewList = array();

$ViewList['signup'] = array(
    'script' => 'signup.php',
    'unordered_params' => array(),
    'params' => array(  ) );

$ViewList['demographics'] = array(
    'script' => 'demographics.php',
    'unordered_params' => array(),
    'params' => array(  ) ,
    'single_post_actions' => array(
        'SubmitButton' => 'Submit')
    );

$FunctionList = array();

?>

<?php

$module = $Params['Module'];
$errors = array();

$http = eZHTTPTool::instance();
$email = $http->variable('email');

if( $module->isCurrentAction( 'Submit' ) ) {

    try {
        $emarsysClient = new EmarsysClient();

        // gather the post variables as fields to map through to Emarsys. The client will filter out those it doesn't recognize.
        $fields = $_POST;
        $emarsysClient->addOrUpdateContactArbitraryFields($fields);

    } catch (Exception $err) {}

    // back to the homepage
    return $module->redirectTo( '/' );
}

$tpl = eZTemplate::factory();
$tpl->setVariable( 'errors', $errors );
$tpl->setVariable( 'email', $email);


$Result            = array();
$Result['content'] = $tpl->fetch( 'design:demographics.tpl' );
$Result['path']    = array(
    array(
        'text' => ezpI18n::tr( 'extension/emarsys', 'More about me' ),
        'url'  => '/'
    )
);

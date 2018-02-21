<?php
/**
 * @package nxcVarnish
 * @class   nxcVarnishClearType
 * @author  Serhey Dolgushev <serhey.dolgushev@nxc.no>
 * @date    23 Jan 2013
 **/

class sendEmarsysContactType extends eZWorkflowEventType
{
	const TYPE_ID = 'sendemarsyscontact';

	public function __construct() {
		$this->eZWorkflowEventType( self::TYPE_ID, 'Send user to Emarsys' );
		$this->setTriggerTypes(
			array(
				'content' => array(
					'publish' => array( 'after', 'before' )
				)
			)
		);
	}

	public function execute( $process, $event ) {
		$parameters = $process->attribute( 'parameter_list' );

		$object = eZContentObject::fetch( $parameters['object_id'] );
		if( $object instanceof eZContentObject === false ) {
			return eZWorkflowType::STATUS_ACCEPTED;
		}

		// check if type is user. If so, send.
        $user = false;
		$identifier = $object->attribute('class_identifier');
        if ($identifier == 'user') {
		    $user = $object;
        }

        // this is not a user, but is a directly related child object that needs to be synced. The parent should be a user that can be sent.
        if ($identifier =='consumer_profile' || $identifier == 'address') {
            $mainNode = $object->mainNode();
            $parentUserNode = $mainNode->fetchParent();
            $user = $parentUserNode->object();
        }

        if ($user) {

            $api = new EmarsysClient();

            try {
                $api->addOrUpdateContact($user->ID);
            } catch (Exception $e) {
                // TODO log Emarsys exceptions to a table
            }
        }

		return eZWorkflowType::STATUS_ACCEPTED;
	}
}

eZWorkflowEventType::registerEventType( sendEmarsysContactType::TYPE_ID, 'sendEmarsysContactType' );

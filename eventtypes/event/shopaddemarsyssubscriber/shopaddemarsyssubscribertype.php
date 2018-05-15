<?php

class ShopAddEmarsysSubscriberType extends eZWorkflowEventType {

    const TYPE_ID = 'shopaddemarsyssubscriber';

    public function __construct() {
        $this->eZWorkflowEventType( self::TYPE_ID, 'Emarsys - Shop add subscriber' );
        $this->setTriggerTypes(
            array(
                'shop'            => array(
                    'confirmorder' => array(
                        'before'
                    )
                ),
                'recurringorders' => array(
                    'checkout' => array(
                        'before'
                    )
                )
            )
        );
    }

    public function execute( $process, $event ) {
        $parameters = $process->attribute( 'parameter_list' );
        $order      = eZOrder::fetch( $parameters['order_id'] );

        if( $this->canAddSubscriber( $order ) ) {
            $this->addSubscriber( $order );
        }

        return eZWorkflowType::STATUS_ACCEPTED;
    }

    public function canAddSubscriber( $order ) {
        $ini          = eZINI::instance( 'emarsys.ini' );
        $checkboxAttr = $ini->variable( 'ShopAddSubscriber', 'NewsletterCheckbox' );

        if( $order instanceof eZOrder ) {
            $xml = new SimpleXMLElement( $order->attribute( 'data_text_1' ) );
            if(
                $xml != null && isset( $xml->{$checkboxAttr} )
            ) {
                return (bool) (string) $xml->{$checkboxAttr};
            }
        }

        return false;
    }

    public function addSubscriber( $order ) {

        $accountInfo = null;
        if( $order instanceof eZOrder ) {
            $accountInfo = new SimpleXMLElement( $order->attribute( 'data_text_1' ) );
            if( $accountInfo === null ) {
                return false;
            }
        }

        $emarsysClient = new EmarsysClient();

        try {
            $emarsysClient->addOrUpdateContactArbitraryFields(
                array(
                    EmarsysClient::EMAIL_ADDRESS_FIELD_NAME => (string)$accountInfo->email,
                    EmarsysClient::FIRST_NAME_FIELD_NAME => (string)$accountInfo->first_name,
                    EmarsysClient::LAST_NAME_FIELD_NAME => (string)$accountInfo->last_name,
                    "street_address" => implode(", ", array($accountInfo->address1, $accountInfo->address2)),
                    "city" => (string)$accountInfo->city,
                    "zipcode" => (string)$accountInfo->zip,
                    EmarsysClient::COUNTRY_FIELD_NAME => (string)$accountInfo->country,
                    EmarsysClient::EMAIL_SUBSCRIPTION_FIELD_NAME => true, // opt in
                    "contact_source" => "Webshop Checkout"
                )
            );

        } catch (Exception $err) {
            // exception has been logged, continue with checkout
        }

    }

}

eZWorkflowEventType::registerEventType( ShopAddEmarsysSubscriberType::TYPE_ID, 'ShopAddEmarsysSubscriberType' );

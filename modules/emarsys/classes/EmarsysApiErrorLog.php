<?php

/**
 * Persistent object to map to emarsys_api_error_logs.
 */
class EmarsysApiErrorLog extends eZPersistentObject
{
    public static function definition()
    {
        return array('fields' =>
            array(
                'id' => array('name' => 'id',
                'datatype' => 'integer',
                'default' => null,
                'required' => true),

                'error_message' => array('name' => 'error_message',
                    'datatype' => 'string',
                    'default' => null,
                    'required' => true),

                'request' => array('name' => 'request',
                    'datatype' => 'string',
                    'default' => null,
                    'required' => true),
            ),

            'keys' => array('id'),
            'class_name' => 'EmarsysApiErrorLog',
            'name' => 'emarsys_api_error_logs',
            'function_attributes' => array()
        );
    }


}
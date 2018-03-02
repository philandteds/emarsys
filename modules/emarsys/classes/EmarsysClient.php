<?php
/**
 * Simple client to interface to the Emarsys client API.
 *
 * User: Mark Howard
 * Date: 20/02/18
 */
class EmarsysClient
{
    private
        $ApiUsername,
        $ApiSecret,
        $ApiUrl,
        $FieldMappings = array(),
        $CountryIDMappings = array();


    const EMAIL_ADDRESS_FIELD_NAME = "email";
    const EMAIL_SUBSCRIPTION_FIELD_NAME = "email_subscription";
    const COUNTRY_FIELD_NAME = "country";
    const FIRST_NAME_FIELD_NAME = "first_name";
    const LAST_NAME_FIELD_NAME = "last_name";

    static $supportedClassIdentifiers = array('user', 'address', 'consumer_profile');
    static $yesNoFieldNames = array('are_pregnant', self::EMAIL_SUBSCRIPTION_FIELD_NAME);


    public function __construct()
    {
        $ini = eZIni::instance('emarsys.ini');
        
        $this->ApiUrl= $ini->variable("EmarsysAPI", "URL");
        $this->ApiUsername = $ini->variable("EmarsysAPI", "Username");
        $this->ApiSecret = $ini->variable("EmarsysAPI", "Secret");
        $this->FieldMappings = $ini->variable("EmarsysAPI", "FieldMappings");
        $this->CountryIDMappings = $ini->variable("EmarsysAPI", "CountryIDMappings");
    }

    public function addOrUpdateContact($userId)
    {
        $user = eZUser::fetch($userId);
        if ($user) {

            $mapping = array(
                $this->FieldMappings[self::EMAIL_ADDRESS_FIELD_NAME] => $user->attribute('email')
            );

            /** @var eZContentObject $contentObject */
            $contentObject = $user->contentObject();
            $mapping = $this->mapFields($contentObject, $mapping);

            // add children (consumer profiles, address) to the mapping
            /** @var eZContentObjectTreeNode $child */
            $mainNode = $contentObject->mainNode();
            foreach ($mainNode->children() as $child) {
                if ($this->isSupportedContentClass($child)) {
                    $mapping = $this->mapFields($child->object(), $mapping);
                }
            }

            return $this->sendAddOrModifyContact($mapping);
        } // if user found

        return false;
    }

    public function addOrUpdateContactArbitraryFields($fields)
    {
        if (!$fields) {
            return false;
        }

        if (!array_key_exists(self::EMAIL_ADDRESS_FIELD_NAME, $fields)) {
            return false;
        }

        return $this->sendAddOrModifyContact($fields);
    }


    public function minimalSubscribe($email, $country, $optIn, $firstName, $lastName) {

        $subscriptionInput = array(
            self::EMAIL_ADDRESS_FIELD_NAME => $email,
            self::COUNTRY_FIELD_NAME => $country,
            self::EMAIL_SUBSCRIPTION_FIELD_NAME => $optIn,
            self::FIRST_NAME_FIELD_NAME => $firstName,
            self::LAST_NAME_FIELD_NAME => $lastName
        );

        $mapping = array ();
        foreach ($subscriptionInput as $field => $value) {
            $mapping = $this->mapField($field, $value, $mapping);
        }

        return $this->sendAddOrModifyContact($mapping);
    }

    public function findFirstContact($emailAddress) {

        $request = array(
            'keyId' => $this->emailFieldID(),
            'keyValues' => array ( $emailAddress )
        );

        $response = $this->send('POST', "contact/getdata", json_encode($request));

        $payload = $response['data'];

        if ($payload) {
            $contactsFound = $payload['result'];
            if ($contactsFound && count($contactsFound) > 0) {
                return $this->unmapFields($contactsFound[0]);
            }
        }

        // nothing found
        return false;
    }

    public function isOptedIn($emailAddress) {
        $contact = $this->findFirstContact($emailAddress);

        if (!$contact) {
            return false;
        }

        return $contact[self::EMAIL_SUBSCRIPTION_FIELD_NAME] ?: false;
    }

    private function mapFields($contentObject, $mapping) {

        $dataMap = $contentObject->dataMap();

        // map values in the data_map to emarsys custom field values
        /** @var eZContentObjectAttribute $contentObjectAttribute */
        foreach ($dataMap as $contentObjectAttribute) {

            if ($contentObjectAttribute->hasContent()) {
                $attributeIdentifier = $contentObjectAttribute->attribute('contentclass_attribute_identifier');
                $attributeValue = $contentObjectAttribute->toString();

                $mapping = $this->mapField($attributeIdentifier, $attributeValue, $mapping);
            }
        }

        return $mapping;
    }

    public function mapField($attributeIdentifier, $attributeValue, $mapping) {

        if (array_key_exists($attributeIdentifier, $this->FieldMappings))
        {
            $emarsysFieldId = $this->FieldMappings[$attributeIdentifier];

            if ($this->isYesNoField($attributeIdentifier)) {
                $mapping[$emarsysFieldId] = $this->findYesNoID($attributeValue);
            } else {

                switch ($attributeIdentifier) {
                    case self::COUNTRY_FIELD_NAME:
                        $countryID = $this->findCountryIDByCountryName($attributeValue);
                        if ($countryID) {
                            $mapping[$emarsysFieldId] = $countryID;
                        }
                        break;
                    default:
                        $mapping[$emarsysFieldId] = $attributeValue;
                        break;
                }
            }

        }

        return $mapping;
    }

    private function unmapFields($emarsysFields) {

        $eZMappings = array();

        foreach ($emarsysFields as $emarsysFieldId => $value) {
            if ($value !== null) {
                $eZFieldName = $this->findEzFieldName($emarsysFieldId);

                if ($eZFieldName) {
                    if ($this->isYesNoField($eZFieldName)) {
                        $eZMappings[$eZFieldName] = $this->findBooleanByYesNoID($value);
                    } else {
                        $eZMappings[$eZFieldName] = $value;
                    }

                }
            }
        }

        return $eZMappings;

    }

    protected function sendAddOrModifyContact($mapping) {
        return $this->send('PUT', 'contact/?create_if_not_exists=1', json_encode($mapping));
    }

    protected function send($requestType, $endPoint, $requestBody = '')
    {
        $deserialized_response = false;

        if (!in_array($requestType, array('GET', 'POST', 'PUT', 'DELETE'))) {
            throw new Exception('Send first parameter must be "GET", "POST", "PUT" or "DELETE"');
        }
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        switch ($requestType)
        {
            case 'GET':
                curl_setopt($ch, CURLOPT_HTTPGET, 1);
                break;
            case 'POST':
                curl_setopt($ch, CURLOPT_POST, 1);
                curl_setopt($ch, CURLOPT_POSTFIELDS, $requestBody);
                break;
            case 'PUT':
                curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "PUT");
                curl_setopt($ch, CURLOPT_POSTFIELDS, $requestBody);
                break;
            case 'DELETE':
                curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "DELETE");
                curl_setopt($ch, CURLOPT_POSTFIELDS, $requestBody);
                break;
        }
        curl_setopt($ch, CURLOPT_HEADER, false); // don't return headers
        $requestUri = $this->ApiUrl . $endPoint;
        curl_setopt($ch, CURLOPT_URL, $requestUri);
        
        $nonce = md5(microtime() . rand(0, PHP_INT_MAX));
        $timestamp = gmdate("c");
        $passwordDigest = base64_encode(sha1($nonce . $timestamp . $this->ApiSecret, false));
        $authHeader = 'X-WSSE: UsernameToken ' .
            'Username="'.$this->ApiUsername.'", ' . 'PasswordDigest="'.$passwordDigest.'", ' . 'Nonce="'.$nonce.'", ' .
            'Created="'.$timestamp.'"';
        curl_setopt($ch, CURLOPT_HTTPHEADER, array($authHeader, 'Content-type: application/json;charset="utf-8"'));
        $output = curl_exec($ch);

        $curl_error = curl_error($ch);
        if ($curl_error) {
            $this->logError($curl_error, $requestBody);
            throw new EmarsysCommsException($curl_error);
        } else {
            $http_error_code = curl_getinfo($ch,CURLINFO_HTTP_CODE);

            $deserialized_response = json_decode($output, true);
            if ($http_error_code < 200 || $http_error_code >= 300) {
                $message = $deserialized_response['replyCode'] . ': '
                    . $deserialized_response['replyText']
                    . ' [' . $deserialized_response['data'] . ']';

                $this->logError($message, $requestBody);
                throw new EmarsysApiException($message, $http_error_code);
            }
        }

        curl_close($ch);
        return $deserialized_response;
    }

    private function isSupportedContentClass($contentObject)
    {
        return in_array($contentObject->attribute('class_identifier'), self::$supportedClassIdentifiers);
    }

    private function isYesNoField($fieldName) {
        return in_array($fieldName, self::$yesNoFieldNames);
    }

    protected function logError($errorMessage, $requestJson) {

        $row = new EmarsysApiErrorLog(
            array(
                'error_message' => $errorMessage,
                'request' => $requestJson
            )
        );

        $row->store();
    }

    private function emailFieldID() {
        return $this->FieldMappings[self::EMAIL_ADDRESS_FIELD_NAME];
    }

    private function findEzFieldName($emarsysFieldIDToFind) {

        foreach ($this->FieldMappings as $eZFieldName => $emarSysFieldID) {
            if ($emarSysFieldID == $emarsysFieldIDToFind) {
                return $eZFieldName;
            }
        }

        return false;
    }

    private function findCountryIDByCountryName($countryNameToFind) {

        if (!$countryNameToFind) {
            return false;
        }

        $countryNameToFind = strtolower(trim($countryNameToFind));
        foreach($this->CountryIDMappings as $countryName => $countryID) {
            if (strtolower($countryName) == $countryNameToFind) {
                return $countryID;
            }
        }
        return false;
    }

    private function findYesNoID($yesNo) {
        if ($yesNo) {
            return 1;
        } else {
            return 2;
        }
    }

    private function findBooleanByYesNoID($yesNoId) {

        switch ($yesNoId) {
            case "1":
                return true;
            default:
                return false;
        }

    }

}
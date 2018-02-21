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

    static $supportedClassIdentifiers = array('user', 'address', 'consumer_profile');


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
                $this->FieldMappings['email'] => $user->attribute('email')
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


            return $this->send('PUT', 'contact/?create_if_not_exists=1', json_encode($mapping));
        } // if user found

        return false;
    }

    /**
     *
     * @param eZContentObject $contentObject
     * @param array $mapping
     */
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

            switch ($attributeIdentifier) {
                case 'are_pregnant':
                case 'email_subscription':
                    $mapping[$emarsysFieldId] = $this->findYesNoID($attributeValue);
                    break;
                case 'country':
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

        return $mapping;

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
            throw new EmarsysCommsException($curl_error);
        } else {
            $http_error_code = curl_getinfo($ch,CURLINFO_HTTP_CODE);

            $deserialized_response = json_decode($output, true);
            if ($http_error_code < 200 || $http_error_code >= 300) {
                throw new EmarsysApiException($deserialized_response['replyCode'] . ': '
                    . $deserialized_response['replyText']
                    . ' [' . $deserialized_response['data'] . ']', $http_error_code);
            }

        }

        curl_close($ch);
        return $deserialized_response;
    }

    private function isSupportedContentClass($contentObject)
    {
        return in_array($contentObject->attribute('class_identifier'), self::$supportedClassIdentifiers);
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
}
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
        $FieldMappings = array();
    
    public function __construct()
    {
        $ini = eZIni::instance();
        
        $this->ApiUrl= $ini->variable("EmarsysAPI", "URL");
        $this->ApiUsername = $ini->variable("EmarsysAPI", "Username");
        $this->ApiSecret = $ini->variable("EmarsysAPI", "Secret");
        $this->FieldMappings = $ini->variable("EmarsysAPI", "FieldMappings");
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
            foreach ($contentObject->mainNode()->children() as $child) {
                $mapping = $this->mapFields($child->object(), $mapping);
            }


            return $this->send('PUT', '/contact/?create_if_not_exists=1', json_encode($mapping));
        } // if user found

        return false;
    }

    /**
     *
     * @param eZContentObject $contentObject
     * @param array $mapping
     */
    private function mapFields($contentObject, $mapping) {
        $userClassIdentifiers = array('user', 'address', 'consumer_profile');

        if (in_array($contentObject->attribute('identifier'), $userClassIdentifiers)) {

            $dataMap = $contentObject->dataMap();

            // map values in the data_map to emarsys custom field values
            /** @var eZContentObjectAttribute $contentObjectAttribute */
            foreach ($dataMap as $contentObjectAttribute) {

                if ($contentObjectAttribute->hasContent()) {
                    $attributeIdentifier = $contentObjectAttribute->attribute('contentclass_attribute_identifier');

                    if (array_key_exists($attributeIdentifier, $this->FieldMappings))
                    {
                        $emarsysFieldId = $this->FieldMappings[$attributeIdentifier];
                        $mapping[$emarsysFieldId] = $contentObjectAttribute->toString();
                    }
                }
            }

        } // if user

        return $mapping;
    }


    protected function send($requestType, $endPoint, $requestBody = '')
    {
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
        curl_setopt($ch, CURLOPT_HEADER, true);
        $requestUri = $this->ApiUrl . $endPoint;
        curl_setopt($ch, CURLOPT_URL, $requestUri);
        
        $nonce = md5(microtime() . rand(0, PHP_INT_MAX));
        $timestamp = gmdate("c");
        $passwordDigest = base64_encode(sha1($nonce . $timestamp . $this->ApiSecret, false));
        curl_setopt($ch, CURLOPT_HTTPHEADER, array(
            'X-WSSE: UsernameToken ' .
            'Username="'.$this->ApiUsername.'", ' . 'PasswordDigest="'.$passwordDigest.'", ' . 'Nonce="'.$nonce.'", ' . 
            'Created=\"'.$timestamp.'"', 'Content-type: application/json;charset="utf-8"')
        );
        $output = curl_exec($ch);
        curl_close($ch);
        return $output;
    }
}